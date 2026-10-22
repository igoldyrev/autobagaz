<?php

declare(strict_types=1);

// Read-only verification of an already imported backup, via a local Unix socket.
if (PHP_SAPI !== 'cli' || $argc !== 5) {
    fwrite(STDERR, "Usage: php scripts/verify-mysql-backup.php BACKUP_DIRECTORY SOCKET DATABASE USER\n");
    exit(2);
}

try {
    [, $directory, $socket, $database, $user] = $argv;
    if (! is_file($directory.'/manifest.json') || ! file_exists($socket)
        || preg_match('/[;\r\n]/', $socket.$database)) {
        throw new RuntimeException('Invalid backup directory or local socket/database.');
    }
    $manifest = json_decode(file_get_contents($directory.'/manifest.json'), true, flags: JSON_THROW_ON_ERROR);
    foreach (['database.sql.gz', 'data.ndjson.gz', 'site.zip'] as $file) {
        if (! hash_equals($manifest['artifacts'][$file]['sha256'], hash_file('sha256', $directory.'/'.$file))) {
            throw new RuntimeException('Backup checksum mismatch: '.$file);
        }
    }
    $pdo = new PDO("mysql:unix_socket=$socket;dbname=$database;charset=utf8mb4", $user, '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_STRINGIFY_FETCHES => true,
    ]);
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    $pdo->exec('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ');
    $pdo->exec('START TRANSACTION WITH CONSISTENT SNAPSHOT, READ ONLY');
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    $expectedTables = array_keys($manifest['tables']);
    sort($tables);
    sort($expectedTables);
    if ($tables !== $expectedTables) {
        throw new RuntimeException('Restored tables differ from the backup.');
    }

    $expected = [];
    $columns = [];
    $input = gzopen($directory.'/data.ndjson.gz', 'rb');
    while (($line = gzgets($input)) !== false) {
        $item = json_decode($line, true, flags: JSON_THROW_ON_ERROR);
        if (isset($item['table'])) {
            $table = $item['table'];
            $columns[$table] = $item['columns'];
            $expected[$table] = [];
        } else {
            $expected[$table][] = hash('sha256', json_encode($item['row'], JSON_THROW_ON_ERROR));
        }
    }
    gzclose($input);
    $quote = static fn (string $value): string => '`'.str_replace('`', '``', $value).'`';
    $verified = [];
    foreach ($tables as $table) {
        $name = $quote($table);
        $actualColumns = array_column($pdo->query('SHOW COLUMNS FROM '.$name)->fetchAll(PDO::FETCH_ASSOC), 'Field');
        if ($actualColumns !== ($columns[$table] ?? null)) {
            throw new RuntimeException('Restored columns differ: '.$table);
        }
        $rows = [];
        $query = $pdo->query('SELECT * FROM '.$name);
        while ($row = $query->fetch(PDO::FETCH_NUM)) {
            $encoded = array_map(static fn ($value) => $value === null ? null : base64_encode((string) $value), $row);
            $rows[] = hash('sha256', json_encode($encoded, JSON_THROW_ON_ERROR));
        }
        sort($rows);
        sort($expected[$table]);
        if ($rows !== $expected[$table] || count($rows) !== $manifest['tables'][$table]) {
            throw new RuntimeException('Restored row contents/count differ: '.$table);
        }
        $verified[$table] = count($rows);
    }

    // Re-enabling FOREIGN_KEY_CHECKS after import does not validate existing rows.
    $constraints = [];
    $query = $pdo->query('SELECT TABLE_NAME, CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
        FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE()
        AND REFERENCED_TABLE_NAME IS NOT NULL ORDER BY TABLE_NAME, CONSTRAINT_NAME, ORDINAL_POSITION');
    foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $key) {
        $constraints[$key['TABLE_NAME'].'/'.$key['CONSTRAINT_NAME']][] = $key;
    }
    foreach ($constraints as $keys) {
        $child = $quote($keys[0]['TABLE_NAME']);
        $parent = $quote($keys[0]['REFERENCED_TABLE_NAME']);
        $joins = $notNull = [];
        foreach ($keys as $key) {
            $joins[] = 'c.'.$quote($key['COLUMN_NAME']).' = p.'.$quote($key['REFERENCED_COLUMN_NAME']);
            $notNull[] = 'c.'.$quote($key['COLUMN_NAME']).' IS NOT NULL';
        }
        $sql = 'SELECT COUNT(*) FROM '.$child.' c LEFT JOIN '.$parent.' p ON '.implode(' AND ', $joins)
            .' WHERE '.implode(' AND ', $notNull).' AND p.'.$quote($keys[0]['REFERENCED_COLUMN_NAME']).' IS NULL';
        if ((int) $pdo->query($sql)->fetchColumn() !== 0) {
            throw new RuntimeException('Restored foreign key has orphan rows: '.$keys[0]['TABLE_NAME']);
        }
    }
    $pdo->exec('COMMIT');
    echo json_encode([
        'verified_at' => gmdate(DATE_ATOM),
        'server_version' => $version,
        'database' => $database,
        'backup_sha256' => $manifest['artifacts']['database.sql.gz']['sha256'],
        'artifact_checksums' => 'ok',
        'row_contents' => 'all columns of all rows match the portable export',
        'foreign_keys_checked' => count($constraints),
        'foreign_key_violations' => 0,
        'tables' => $verified,
    ], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT)."\n";
} catch (Throwable $error) {
    fwrite(STDERR, $error instanceof PDOException ? "Database verification query failed.\n" : $error->getMessage()."\n");
    exit(1);
}

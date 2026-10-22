<?php

// Uploaded temporarily by backup-sftp.py; never install this as a public endpoint.
declare(strict_types=1);
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

header('Content-Type: application/json');
header('Cache-Control: no-store');
if (! hash_equals('__BACKUP_TOKEN__', $_SERVER['HTTP_AUTHORIZATION'] ?? '')) {
    http_response_code(404);
    exit;
}
unlink(__FILE__);
umask(0077);
set_time_limit(180);

try {
    $root = dirname(__DIR__);
    require $root.'/vendor/autoload.php';
    $app = require $root.'/bootstrap/app.php';
    $app->make(Kernel::class)->bootstrap();
    $db = DB::connection();
    if ($db->getDriverName() !== 'mysql') {
        throw new RuntimeException('Only MySQL exports are supported.');
    }
    $pdo = $db->getPdo();
    $tables = $pdo->query('SHOW FULL TABLES')->fetchAll(PDO::FETCH_NUM);
    foreach ($tables as [$table, $type]) {
        if ($type !== 'BASE TABLE') {
            throw new RuntimeException('Views require a separate backup procedure.');
        }
    }
    if ($pdo->query('SHOW TRIGGERS')->fetch() !== false) {
        throw new RuntimeException('Triggers require a separate backup procedure.');
    }
    foreach (['ROUTINES' => 'ROUTINE_SCHEMA', 'EVENTS' => 'EVENT_SCHEMA'] as $type => $column) {
        $query = $pdo->prepare("SELECT COUNT(*) FROM information_schema.$type WHERE $column = DATABASE()");
        $query->execute();
        if ((int) $query->fetchColumn() !== 0) {
            throw new RuntimeException('Stored routines/events require a separate backup procedure.');
        }
    }
    foreach ($pdo->query('SHOW TABLE STATUS')->fetchAll(PDO::FETCH_ASSOC) as $status) {
        if ($status['Engine'] !== 'InnoDB') {
            throw new RuntimeException('A consistent export requires InnoDB tables.');
        }
    }
    $directory = $root.'/storage/app/deploy/__BACKUP_ID__';
    if (! mkdir($directory, 0700)) {
        throw new RuntimeException('Cannot create backup directory.');
    }
    $sql = gzopen($directory.'/database.sql.gz', 'wb6');
    $data = gzopen($directory.'/data.ndjson.gz', 'wb6');
    if (! $sql || ! $data) {
        throw new RuntimeException('Cannot create export files.');
    }
    $write = static function ($stream, string $value): void {
        if (gzwrite($stream, $value) !== strlen($value)) {
            throw new RuntimeException('Incomplete database write.');
        }
    };
    $quote = static fn (string $name): string => '`'.str_replace('`', '``', $name).'`';
    $counts = [];
    $pdo->exec('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ');
    $pdo->exec('START TRANSACTION WITH CONSISTENT SNAPSHOT, READ ONLY');
    $write($sql, "SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\nSET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n");
    foreach ($tables as [$table]) {
        $name = $quote($table);
        $create = $pdo->query('SHOW CREATE TABLE '.$name)->fetch(PDO::FETCH_NUM)[1];
        $write($sql, "DROP TABLE IF EXISTS $name;\n$create;\n");
        $columns = array_column($pdo->query('SHOW COLUMNS FROM '.$name)->fetchAll(PDO::FETCH_ASSOC), 'Field');
        $write($data, json_encode(['table' => $table, 'columns' => $columns], JSON_THROW_ON_ERROR)."\n");
        $select = $pdo->query('SELECT * FROM '.$name);
        $counts[$table] = 0;
        while ($row = $select->fetch(PDO::FETCH_NUM)) {
            $write($data, json_encode(['row' => array_map(static fn ($v) => $v === null ? null : base64_encode((string) $v), $row)], JSON_THROW_ON_ERROR)."\n");
            $values = array_map(static fn ($v) => $v === null ? 'NULL' : $pdo->quote((string) $v), $row);
            $write($sql, 'INSERT INTO '.$name.' ('.implode(',', array_map($quote, $columns)).') VALUES ('.implode(',', $values).");\n");
            $counts[$table]++;
        }
    }
    $pdo->exec('COMMIT');
    $write($sql, "SET FOREIGN_KEY_CHECKS=1;\n");
    gzclose($sql);
    gzclose($data);

    // Include the server release, vendor, private files, uploads and .env.
    // Do not follow public/storage or any other symbolic links.
    $zip = new ZipArchive;
    if ($zip->open($directory.'/site.zip', ZipArchive::CREATE | ZipArchive::EXCL) !== true) {
        throw new RuntimeException('Cannot create site archive.');
    }
    $hashes = [];
    $roots = ['app', 'bootstrap', 'config', 'database', 'public', 'resources', 'routes', 'vendor', 'storage/app/public', 'storage/app/private'];
    $files = ['.env', 'artisan', 'composer.json', 'composer.lock', 'package.json', 'package-lock.json'];
    foreach ($roots as $path) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/'.$path, FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            if ($file->isFile() && ! $file->isLink()) {
                $relative = substr($file->getPathname(), strlen($root) + 1);
                if (! str_starts_with($relative, 'bootstrap/cache/') && ! str_ends_with($relative, '.sqlite') && ! str_contains($relative, '.sqlite-')) {
                    $files[] = $relative;
                }
            }
        }
    }
    foreach ($files as $file) {
        if (! is_file($root.'/'.$file) || is_link($root.'/'.$file)) {
            throw new RuntimeException('Missing or unsupported archive file.');
        }
        $hashes[$file] = hash_file('sha256', $root.'/'.$file);
        if (! $zip->addFile($root.'/'.$file, $file)) {
            throw new RuntimeException('Cannot add archive file.');
        }
    }
    if (! $zip->close()) {
        throw new RuntimeException('Cannot finish site archive.');
    }
    // Detect files changed while ZipArchive was reading them.
    $check = new ZipArchive;
    if ($check->open($directory.'/site.zip') !== true) {
        throw new RuntimeException('Cannot verify site archive.');
    }
    foreach ($hashes as $file => $hash) {
        $stream = $check->getStream($file);
        $context = hash_init('sha256');
        hash_update_stream($context, $stream);
        fclose($stream);
        if (! hash_equals($hash, hash_final($context))) {
            throw new RuntimeException('A file changed during backup; retry.');
        }
    }
    $check->close();
    $manifest = ['version' => 1, 'created_at' => gmdate(DATE_ATOM), 'tables' => $counts, 'site_files' => $hashes, 'artifacts' => []];
    foreach (['database.sql.gz', 'data.ndjson.gz', 'site.zip'] as $file) {
        $manifest['artifacts'][$file] = ['sha256' => hash_file('sha256', $directory.'/'.$file), 'bytes' => filesize($directory.'/'.$file)];
    }
    file_put_contents($directory.'/manifest.json', json_encode($manifest, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
    echo json_encode(['ok' => true, 'artifacts' => $manifest['artifacts'], 'tables' => $counts], JSON_THROW_ON_ERROR);
} catch (Throwable $error) {
    http_response_code(500);
    // Avoid exposing PDO errors, connection parameters or customer data.
    echo json_encode(['ok' => false, 'error' => 'Backup failed: '.get_class($error)]);
}

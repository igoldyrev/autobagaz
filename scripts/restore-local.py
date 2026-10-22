#!/usr/bin/env python3
"""Validate a backup in isolation, then synchronize the local SQLite and uploads."""

import argparse
import base64
import datetime
import gzip
import hashlib
import json
import os
from pathlib import Path, PurePosixPath
import re
import shutil
import sqlite3
import subprocess
import tempfile
import zipfile


PROJECT = Path(__file__).resolve().parent.parent


def identifier(value):
    return '"' + value.replace('"', '""') + '"'


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("backup", type=Path)
    parser.add_argument("--activate", action="store_true", help="Replace local data after verification (default: verify only)")
    args = parser.parse_args()
    os.umask(0o077)
    source = args.backup.resolve()
    manifest = json.loads((source / "manifest.json").read_text())
    for name in ["site.zip", "data.ndjson.gz", "database.sql.gz"]:
        with (source / name).open("rb") as stream:
            if hashlib.file_digest(stream, "sha256").hexdigest() != manifest["artifacts"][name]["sha256"]:
                raise RuntimeError("Backup checksum mismatch: " + name)
    with tempfile.TemporaryDirectory(prefix="autobagaz-restore-", dir=PROJECT / ".codex") as temp:
        temp = Path(temp)
        database = temp / "restored.sqlite"
        database.touch(mode=0o600)
        uploads = temp / "public"
        uploads.mkdir()
        env = dict(os.environ, APP_ENV="local", DB_CONNECTION="sqlite", DB_DATABASE=str(database), DB_URL="", APP_CONFIG_CACHE=str(temp / "config.php"), MAIL_MAILER="log", TELEGRAM_BOT_TOKEN="", TELEGRAM_ALERT_CHAT_IDS="", QUEUE_CONNECTION="sync", CACHE_STORE="file")
        subprocess.run(["php", "artisan", "migrate", "--force", "--no-interaction"], cwd=PROJECT, env=env, check=True, stdout=subprocess.DEVNULL)
        connection = sqlite3.connect(database)
        connection.execute("PRAGMA foreign_keys=OFF")
        tables = {row[0] for row in connection.execute("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")}
        if tables != set(manifest["tables"]):
            raise RuntimeError("Server/local schema tables differ: " + str(sorted(tables.symmetric_difference(manifest["tables"]))))
        with connection:
            for table in tables:
                connection.execute("DELETE FROM " + identifier(table))
            imported = {}
            with gzip.open(source / "data.ndjson.gz", "rt") as stream:
                for line in stream:
                    item = json.loads(line)
                    if "table" in item:
                        table = item["table"]
                        if table in imported or table not in tables:
                            raise RuntimeError("Unexpected or duplicate export table")
                        columns = item["columns"]
                        local = [row[1] for row in connection.execute("PRAGMA table_info(" + identifier(table) + ")")]
                        if set(local) != set(columns):
                            raise RuntimeError("Column mismatch: " + table)
                        insert = "INSERT INTO " + identifier(table) + " (" + ",".join(map(identifier, columns)) + ") VALUES (" + ",".join("?" for _ in columns) + ")"
                        imported[table] = 0
                    else:
                        row = []
                        for value in item["row"]:
                            if value is None:
                                row.append(None)
                            else:
                                decoded = base64.b64decode(value, validate=True)
                                try:
                                    row.append(decoded.decode("utf-8"))
                                except UnicodeDecodeError:
                                    row.append(decoded)
                        connection.execute(insert, row)
                        imported[table] += 1
        actual = {table: connection.execute("SELECT COUNT(*) FROM " + identifier(table)).fetchone()[0] for table in tables}
        if imported != manifest["tables"] or actual != manifest["tables"]:
            raise RuntimeError("Row counts differ from the snapshot")
        if connection.execute("PRAGMA integrity_check").fetchall() != [("ok",)] or connection.execute("PRAGMA foreign_key_check").fetchone():
            raise RuntimeError("Restored database integrity/foreign keys failed")
        with zipfile.ZipFile(source / "site.zip") as archive:
            if set(archive.namelist()) != set(manifest["site_files"]):
                raise RuntimeError("Archive inventory mismatch")
            for name, expected in manifest["site_files"].items():
                with archive.open(name) as stream:
                    if hashlib.file_digest(stream, "sha256").hexdigest() != expected:
                        raise RuntimeError("Archive file checksum mismatch")
                if name.startswith("storage/app/public/"):
                    relative = PurePosixPath(name).relative_to("storage/app/public")
                    if ".." in relative.parts or relative.is_absolute():
                        raise RuntimeError("Unsafe archive path")
                    path = uploads.joinpath(*relative.parts)
                    path.parent.mkdir(parents=True, exist_ok=True)
                    path.write_bytes(archive.read(name))
            # Every local image reference must resolve to a backed-up file.
            missing = set()
            for table in tables:
                columns = [row[1] for row in connection.execute("PRAGMA table_info(" + identifier(table) + ")") if row[2].upper() not in ("INTEGER", "REAL", "NUMERIC")]
                for column in columns:
                    query = "SELECT DISTINCT " + identifier(column) + " FROM " + identifier(table) + " WHERE " + identifier(column) + " LIKE 'storage/%'"
                    for (value,) in connection.execute(query):
                        if isinstance(value, str) and "storage/app/public/" + value.removeprefix("storage/") not in manifest["site_files"]:
                            missing.add(value)
            if missing:
                raise RuntimeError("Missing backed-up uploads: " + str(len(missing)))
        connection.close()
        report = {"verified_at": datetime.datetime.now(datetime.timezone.utc).isoformat(), "tables": actual, "integrity_check": "ok", "foreign_key_check": "ok", "archive_checksums": "ok", "upload_references": "ok"}
        (source / "restore-check.json").write_text(json.dumps(report, indent=2))
        print("Isolated restore verified: " + str(len(actual)) + " tables, " + str(sum(actual.values())) + " rows", flush=True)
        if not args.activate:
            return
        local_database = PROJECT / "database/database.sqlite"
        if any(Path(str(local_database) + suffix).exists() for suffix in ["-wal", "-shm", "-journal"]):
            raise RuntimeError("Stop local application/workers and checkpoint SQLite before activation")
        # Keep the local APP_KEY and all other development settings. Never copy server .env.
        dotenv = PROJECT / ".env"
        content = dotenv.read_text()
        settings = {"APP_ENV": "local", "APP_URL": "http://127.0.0.1:8000", "DB_CONNECTION": "sqlite", "DB_DATABASE": str(local_database), "DB_URL": "", "MAIL_MAILER": "log", "TELEGRAM_BOT_TOKEN": "", "TELEGRAM_ALERT_CHAT_IDS": "", "QUEUE_CONNECTION": "sync", "CACHE_STORE": "file", "SESSION_DRIVER": "file"}
        for key, value in settings.items():
            pattern = r"^" + re.escape(key) + r"=.*$"
            line = key + "=" + json.dumps(value)
            content = re.sub(pattern, lambda _: line, content, flags=re.MULTILINE) if re.search(pattern, content, re.MULTILINE) else content.rstrip() + "\n" + line + "\n"
        rollback = PROJECT / ".codex/data-backup/local-before-sync" / datetime.datetime.now(datetime.timezone.utc).strftime("%Y%m%dT%H%M%S%fZ")
        rollback.mkdir(parents=True, mode=0o700)
        old_connection = sqlite3.connect(local_database)
        with sqlite3.connect(rollback / "database.sqlite") as saved:
            old_connection.backup(saved)
        old_connection.close()
        shutil.copy2(dotenv, rollback / ".env")
        public = PROJECT / "storage/app/public"
        shutil.copytree(public, rollback / "public")
        try:
            dotenv.write_text(content)
            dotenv.chmod(0o600)
            os.replace(database, local_database)
            shutil.rmtree(public)
            shutil.copytree(uploads, public)
            subprocess.run(["php", "artisan", "optimize:clear"], cwd=PROJECT, check=True, stdout=subprocess.DEVNULL)
            subprocess.run(["php", "artisan", "storage:link"], cwd=PROJECT, check=True, stdout=subprocess.DEVNULL)
        except BaseException:
            shutil.copy2(rollback / ".env", dotenv)
            shutil.copy2(rollback / "database.sqlite", local_database)
            shutil.rmtree(public, ignore_errors=True)
            shutil.copytree(rollback / "public", public)
            raise
        print("Local data synchronized. Previous state: " + str(rollback), flush=True)


if __name__ == "__main__":
    main()

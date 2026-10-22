#!/usr/bin/env python3
"""Download and verify a complete Jino data/release snapshot over SFTP."""

import base64
import datetime
import hashlib
import json
import os
from pathlib import Path
import re
import secrets
import shutil
import subprocess
import tempfile
import time
import urllib.request
import xml.etree.ElementTree as ET
import zipfile


PROJECT = Path(__file__).resolve().parent.parent
BACKUPS = Path(os.environ.get("AUTOBAGAZ_BACKUP_DIR", Path.home() / ".local/share/autobagaz/backups"))
HOST = os.environ.get("DEPLOY_SFTP_HOST", "9082410193.myjino.ru")
PORT = os.environ.get("DEPLOY_SFTP_PORT", "2222")
USER = os.environ.get("DEPLOY_SFTP_USER", "9082410193")
REMOTE = os.environ.get("DEPLOY_REMOTE_ROOT", "apps/autobagaz")
URL = os.environ.get("DEPLOY_SITE_URL", "https://new.autobagaz.ru")


def quote(value):
    value = str(value)
    if any(c in value for c in "\r\n\x00"):
        raise ValueError("Invalid SFTP path")
    return '"' + value.replace("\\", "\\\\").replace('"', '\\"') + '"'


def password():
    if os.environ.get("JINO_SFTP_PASSWORD"):
        return os.environ["JINO_SFTP_PASSWORD"]
    profile = Path(os.environ.get("FILEZILLA_SITEMANAGER", Path.home() / ".config/filezilla/sitemanager.xml"))
    for server in ET.parse(profile).iter("Server"):
        if server.findtext("Host") == os.environ.get("DEPLOY_SFTP_PROFILE_HOST", HOST) and server.findtext("User") == USER:
            node = server.find("Pass")
            return base64.b64decode(node.text).decode() if node.get("encoding") == "base64" else node.text
    raise RuntimeError("Set JINO_SFTP_PASSWORD or configure the existing FileZilla profile")


def main():
    os.umask(0o077)
    BACKUPS.mkdir(parents=True, exist_ok=True, mode=0o700)
    # A single local process may create a backup at a time (also for timer runs).
    import fcntl
    lock = (BACKUPS / ".backup.lock").open("w")
    fcntl.flock(lock, fcntl.LOCK_EX | fcntl.LOCK_NB)
    if shutil.disk_usage(BACKUPS).free < 1024 ** 3:
        raise RuntimeError("Less than 1 GiB free; free disk space before backing up")
    identity = datetime.datetime.now(datetime.timezone.utc).strftime("%Y%m%dT%H%M%SZ") + "-" + secrets.token_hex(4)
    target = BACKUPS / (identity + ".partial")
    target.mkdir(mode=0o700)
    runner_name = "backup-" + secrets.token_hex(16) + ".php"
    remote_dir = REMOTE + "/storage/app/deploy/data-" + identity
    artifact_names = ["manifest.json", "database.sql.gz", "data.ndjson.gz", "site.zip"]
    with tempfile.TemporaryDirectory(prefix="autobagaz-backup-") as temp:
        temp = Path(temp)
        askpass = temp / "askpass.sh"
        askpass.write_text('#!/bin/sh\nprintf "%s\\n" "$JINO_SFTP_PASSWORD"\n')
        askpass.chmod(0o700)
        env = dict(os.environ, JINO_SFTP_PASSWORD=password(), SSH_ASKPASS=str(askpass), SSH_ASKPASS_REQUIRE="force", DISPLAY=":0")

        def sftp(commands):
            batch = temp / "sftp.batch"
            batch.write_text("\n".join(commands) + "\n")
            args = ["sftp", "-q", "-oBatchMode=no", "-oPreferredAuthentications=password", "-oPubkeyAuthentication=no", "-oStrictHostKeyChecking=yes", "-oHostKeyAlias=" + os.environ.get("DEPLOY_SFTP_HOST_KEY_ALIAS", HOST), "-oConnectTimeout=15", "-oServerAliveInterval=15", "-oServerAliveCountMax=2", "-P", PORT, "-b", str(batch), USER + "@" + HOST]
            for attempt in range(4):
                result = subprocess.run(args, env=env, stdin=subprocess.DEVNULL, start_new_session=True)
                if result.returncode == 0:
                    return
                if attempt < 3:
                    time.sleep(5)
            raise RuntimeError("SFTP transfer failed")

        token = "Bearer " + secrets.token_hex(32)
        source = (PROJECT / "scripts/backup-data.php").read_text().replace("__BACKUP_TOKEN__", token).replace("__BACKUP_ID__", "data-" + identity)
        runner = temp / runner_name
        runner.write_text(source)
        try:
            sftp(["put " + quote(runner) + " " + quote(REMOTE + "/public/" + runner_name)])
            request = urllib.request.Request(URL.rstrip("/") + "/" + runner_name, headers={"Authorization": token})
            with urllib.request.urlopen(request, timeout=210) as response:
                result = json.load(response)
            if not result.get("ok"):
                raise RuntimeError("Server snapshot failed")
            print("Server snapshot ready; downloading verified artifacts", flush=True)
            sftp(["get " + quote(remote_dir + "/" + name) + " " + quote(target / name) for name in artifact_names])
            manifest = json.loads((target / "manifest.json").read_text())
            for name in artifact_names[1:]:
                expected = manifest["artifacts"][name]
                path = target / name
                with path.open("rb") as stream:
                    digest = hashlib.file_digest(stream, "sha256").hexdigest()
                if digest != expected["sha256"] or path.stat().st_size != expected["bytes"]:
                    raise RuntimeError("Artifact checksum mismatch: " + name)
            with zipfile.ZipFile(target / "site.zip") as archive:
                if set(archive.namelist()) != set(manifest["site_files"]):
                    raise RuntimeError("Archive inventory mismatch")
                for name, expected in manifest["site_files"].items():
                    with archive.open(name) as stream:
                        if hashlib.file_digest(stream, "sha256").hexdigest() != expected:
                            raise RuntimeError("Site file checksum mismatch")
            completed = BACKUPS / identity
            target.rename(completed)
            print("Verified backup: " + str(completed), flush=True)
            print("Tables: " + str(len(manifest["tables"])) + "; rows: " + str(sum(manifest["tables"].values())), flush=True)
            # Acknowledge only a downloaded and checksum-verified complete snapshot.
            # The API checks the snapshot age, not merely this acknowledgement time.
            status = temp / "last-verified-backup.json"
            status.write_text(json.dumps({
                "snapshot_at": manifest["created_at"],
                "last_verified_at": datetime.datetime.now(datetime.timezone.utc).isoformat(),
            }))
            sftp(["put " + quote(status) + " " + quote(REMOTE + "/storage/app/deploy/last-verified-backup.json")])
            # Delete only this run's temporary server artifacts after verification.
            sftp(["rm " + quote(remote_dir + "/" + name) for name in artifact_names] + ["rmdir " + quote(remote_dir)])
            # Keep one latest snapshot per day/week/month, excluding incomplete runs.
            snapshots = []
            for path in BACKUPS.iterdir():
                if re.fullmatch(r"\d{8}T\d{6}Z-[0-9a-f]{8}", path.name) and path.is_dir() and not path.is_symlink() and (path / "manifest.json").is_file():
                    try:
                        date = datetime.datetime.strptime(path.name[:16], "%Y%m%dT%H%M%SZ")
                        snapshots.append((date, path))
                    except ValueError:
                        continue
            keep = set()
            for key, limit in [(lambda d: d.date(), 14), (lambda d: d.isocalendar()[:2], 8), (lambda d: (d.year, d.month), 6)]:
                groups = set()
                for date, path in sorted(snapshots, reverse=True):
                    group = key(date)
                    if group not in groups and len(groups) < limit:
                        groups.add(group)
                        keep.add(path)
            for _, path in snapshots:
                if path not in keep:
                    shutil.rmtree(path)
        finally:
            sftp(["-rm " + quote(REMOTE + "/public/" + runner_name)])


if __name__ == "__main__":
    main()

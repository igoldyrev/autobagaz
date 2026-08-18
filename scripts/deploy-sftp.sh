#!/usr/bin/env bash

set -Eeuo pipefail

readonly DEFAULT_HOST="9082410193.myjino.ru"
readonly DEFAULT_PORT="2222"
readonly DEFAULT_USER="9082410193"
readonly DEFAULT_REMOTE_ROOT="apps/autobagaz"
readonly DEFAULT_SITE_URL="https://new.autobagaz.ru"

DRY_RUN=false
INITIALIZE=false
FULL_UPLOAD=false
SKIP_CHECKS=false

usage() {
    cat <<'EOF'
Usage: scripts/deploy-sftp.sh [options]

Publishes changed application files to new.autobagaz.ru over SFTP.
Changes are detected using a SHA-256 manifest stored outside the public web root.

Options:
  --dry-run       Show files that would be uploaded without changing the server.
  --initialize    Save the current local manifest on the server without uploading.
                  Use only when the server is already synchronized with this copy.
  --full          Upload every deployable file instead of comparing manifests.
  --skip-checks   Skip npm build, Pint and PHPUnit checks.
  -h, --help      Show this help.

Authentication:
  Set JINO_SFTP_PASSWORD, or keep the Jino connection in FileZilla's
  ~/.config/filezilla/sitemanager.xml. Passwords are never written to the project.

Optional environment overrides:
  DEPLOY_SFTP_HOST, DEPLOY_SFTP_PORT, DEPLOY_SFTP_USER,
  DEPLOY_REMOTE_ROOT, DEPLOY_SITE_URL, FILEZILLA_SITEMANAGER
EOF
}

while (($# > 0)); do
    case "$1" in
        --dry-run) DRY_RUN=true ;;
        --initialize) INITIALIZE=true ;;
        --full) FULL_UPLOAD=true ;;
        --skip-checks) SKIP_CHECKS=true ;;
        -h|--help) usage; exit 0 ;;
        *) echo "Unknown option: $1" >&2; usage >&2; exit 2 ;;
    esac
    shift
done

if $INITIALIZE && $FULL_UPLOAD; then
    echo "--initialize and --full cannot be used together." >&2
    exit 2
fi

readonly SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
readonly PROJECT_ROOT="$(cd -- "$SCRIPT_DIR/.." && pwd)"
cd "$PROJECT_ROOT"

readonly SFTP_HOST="${DEPLOY_SFTP_HOST:-$DEFAULT_HOST}"
readonly SFTP_PORT="${DEPLOY_SFTP_PORT:-$DEFAULT_PORT}"
readonly SFTP_USER="${DEPLOY_SFTP_USER:-$DEFAULT_USER}"
readonly REMOTE_ROOT="${DEPLOY_REMOTE_ROOT:-$DEFAULT_REMOTE_ROOT}"
readonly SITE_URL="${DEPLOY_SITE_URL:-$DEFAULT_SITE_URL}"
readonly FILEZILLA_XML="${FILEZILLA_SITEMANAGER:-$HOME/.config/filezilla/sitemanager.xml}"
readonly REMOTE_MANIFEST="$REMOTE_ROOT/storage/app/deploy/sftp-manifest.tsv"

for command in php sftp curl sha256sum openssl setsid; do
    command -v "$command" >/dev/null || { echo "Required command not found: $command" >&2; exit 1; }
done

if ! $SKIP_CHECKS && ! $DRY_RUN && ! $INITIALIZE; then
    echo "Running production checks..."
    npm run build
    vendor/bin/pint --test
    php artisan test
    git diff --check
fi

if [[ -z "${JINO_SFTP_PASSWORD:-}" ]]; then
    [[ -f "$FILEZILLA_XML" ]] || {
        echo "Set JINO_SFTP_PASSWORD or configure FileZilla: $FILEZILLA_XML" >&2
        exit 1
    }

    JINO_SFTP_PASSWORD="$(DEPLOY_LOOKUP_HOST="$SFTP_HOST" DEPLOY_LOOKUP_USER="$SFTP_USER" php -r '
        $xml = simplexml_load_file($argv[1]);
        foreach ($xml->Servers->Server as $server) {
            if ((string) $server->Host === getenv("DEPLOY_LOOKUP_HOST") && (string) $server->User === getenv("DEPLOY_LOOKUP_USER")) {
                $password = (string) $server->Pass;
                echo (string) $server->Pass["encoding"] === "base64" ? base64_decode($password) : $password;
                exit(0);
            }
        }
        fwrite(STDERR, "Matching FileZilla profile not found.\n");
        exit(1);
    ' "$FILEZILLA_XML")"
fi
export JINO_SFTP_PASSWORD

readonly TEMP_DIR="$(mktemp -d /tmp/autobagaz-sftp-deploy.XXXXXX)"
readonly ASKPASS_SCRIPT="$TEMP_DIR/askpass.sh"
readonly LOCAL_MANIFEST="$TEMP_DIR/local-manifest.tsv"
readonly OLD_MANIFEST="$TEMP_DIR/remote-manifest.tsv"
readonly SFTP_BATCH="$TEMP_DIR/sftp.batch"
readonly RELEASE_RESULT="$TEMP_DIR/release-result.json"

cleanup() {
    unset JINO_SFTP_PASSWORD
    rm -rf -- "$TEMP_DIR"
}
trap cleanup EXIT

cat > "$ASKPASS_SCRIPT" <<'EOF'
#!/bin/sh
printf '%s\n' "$JINO_SFTP_PASSWORD"
EOF
chmod 700 "$ASKPASS_SCRIPT"

run_sftp() {
    SSH_ASKPASS="$ASKPASS_SCRIPT" \
    SSH_ASKPASS_REQUIRE=force \
    DISPLAY=:0 \
    setsid -w sftp -q \
        -o BatchMode=no \
        -o PreferredAuthentications=password \
        -o PubkeyAuthentication=no \
        -o StrictHostKeyChecking=yes \
        -P "$SFTP_PORT" \
        -b "$1" \
        "$SFTP_USER@$SFTP_HOST" </dev/null
}

sftp_quote() {
    local value="$1"
    value="${value//\\/\\\\}"
    value="${value//\"/\\\"}"
    printf '"%s"' "$value"
}

deployable_files() {
    local roots=(
        app
        bootstrap/app.php
        bootstrap/providers.php
        config
        database/data
        database/migrations
        database/seeders
        public
        resources
        routes
        composer.json
        composer.lock
    )

    find "${roots[@]}" -type f \
        ! -path 'public/storage/*' \
        ! -path 'public/hot' \
        ! -name '.DS_Store' \
        -print0 | sort -z
}

while IFS= read -r -d '' file; do
    [[ "$file" != *$'\t'* && "$file" != *$'\n'* ]] || {
        echo "Tabs and newlines are not supported in deploy paths: $file" >&2
        exit 1
    }
    printf '%s\t%s\n' "$(sha256sum "$file" | cut -d ' ' -f 1)" "$file" >> "$LOCAL_MANIFEST"
done < <(deployable_files)

printf '%s\n' "-get $(sftp_quote "$REMOTE_MANIFEST") $(sftp_quote "$OLD_MANIFEST")" > "$SFTP_BATCH"
run_sftp "$SFTP_BATCH" || true

declare -A OLD_HASHES=()
if [[ -s "$OLD_MANIFEST" ]]; then
    while IFS=$'\t' read -r hash file; do
        OLD_HASHES["$file"]="$hash"
    done < "$OLD_MANIFEST"
elif ! $FULL_UPLOAD && ! $INITIALIZE; then
    echo "Remote deploy manifest is missing." >&2
    echo "Run once with --initialize if the server is synchronized, or --full to upload everything." >&2
    exit 1
fi

declare -a CHANGED_FILES=()
while IFS=$'\t' read -r hash file; do
    if $FULL_UPLOAD || [[ "${OLD_HASHES[$file]:-}" != "$hash" ]]; then
        CHANGED_FILES+=("$file")
    fi
done < "$LOCAL_MANIFEST"

if $INITIALIZE; then
    : > "$SFTP_BATCH"
    printf '%s\n' "-mkdir $(sftp_quote "$REMOTE_ROOT/storage/app/deploy")" >> "$SFTP_BATCH"
    printf '%s\n' "put $(sftp_quote "$LOCAL_MANIFEST") $(sftp_quote "$REMOTE_MANIFEST")" >> "$SFTP_BATCH"
    run_sftp "$SFTP_BATCH"
    echo "Remote manifest initialized with $(wc -l < "$LOCAL_MANIFEST") files."
    exit 0
fi

if ((${#CHANGED_FILES[@]} == 0)); then
    echo "No changed deployable files."
    exit 0
fi

echo "Files to upload (${#CHANGED_FILES[@]}):"
printf '  %s\n' "${CHANGED_FILES[@]}"

if $DRY_RUN; then
    exit 0
fi

readonly BACKUP_DIR="$PROJECT_ROOT/.codex/deploy/backups/$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"
: > "$SFTP_BATCH"

for file in "${CHANGED_FILES[@]}"; do
    if [[ -n "${OLD_HASHES[$file]:-}" ]]; then
        mkdir -p "$BACKUP_DIR/$(dirname "$file")"
        printf '%s\n' "-get $(sftp_quote "$REMOTE_ROOT/$file") $(sftp_quote "$BACKUP_DIR/$file")" >> "$SFTP_BATCH"
    fi
done
run_sftp "$SFTP_BATCH" || true

declare -A REMOTE_DIRS=()
for file in "${CHANGED_FILES[@]}"; do
    directory="$(dirname "$file")"
    while [[ "$directory" != "." && -n "$directory" ]]; do
        REMOTE_DIRS["$directory"]=1
        directory="$(dirname "$directory")"
    done
done

: > "$SFTP_BATCH"
while IFS= read -r directory; do
    printf '%s\n' "-mkdir $(sftp_quote "$REMOTE_ROOT/$directory")" >> "$SFTP_BATCH"
done < <(printf '%s\n' "${!REMOTE_DIRS[@]}" | sort)

for file in "${CHANGED_FILES[@]}"; do
    printf '%s\n' "put $(sftp_quote "$PROJECT_ROOT/$file") $(sftp_quote "$REMOTE_ROOT/$file")" >> "$SFTP_BATCH"
done
run_sftp "$SFTP_BATCH"

readonly RUNNER_NAME="codex-release-$(openssl rand -hex 16).php"
readonly RUNNER_FILE="$TEMP_DIR/$RUNNER_NAME"

cat > "$RUNNER_FILE" <<'PHP'
<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

try {
    require dirname(__DIR__).'/vendor/autoload.php';
    $app = require_once dirname(__DIR__).'/bootstrap/app.php';
    $app->make(Kernel::class)->bootstrap();

    $results = [];
    foreach (['optimize:clear', 'migrate', 'optimize'] as $command) {
        $exitCode = Artisan::call($command, $command === 'migrate' ? ['--force' => true] : []);
        $results[$command] = ['exit_code' => $exitCode, 'output' => trim(Artisan::output())];
        if ($exitCode !== 0) {
            throw new RuntimeException("Command failed: {$command}");
        }
    }

    echo json_encode(['ok' => true, 'results' => $results], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Throwable $exception) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $exception->getMessage()], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
PHP

printf '%s\n' "put $(sftp_quote "$RUNNER_FILE") $(sftp_quote "$REMOTE_ROOT/public/$RUNNER_NAME")" > "$SFTP_BATCH"
run_sftp "$SFTP_BATCH"

set +e
HTTP_STATUS="$(curl -sS --connect-timeout 15 --max-time 180 -o "$RELEASE_RESULT" -w '%{http_code}' "$SITE_URL/$RUNNER_NAME")"
CURL_STATUS=$?
set -e

printf '%s\n' "rm $(sftp_quote "$REMOTE_ROOT/public/$RUNNER_NAME")" > "$SFTP_BATCH"
run_sftp "$SFTP_BATCH"

if ((CURL_STATUS != 0)) || [[ "$HTTP_STATUS" != "200" ]]; then
    echo "Remote release command failed (HTTP $HTTP_STATUS)." >&2
    cat "$RELEASE_RESULT" >&2 || true
    echo "Backup: $BACKUP_DIR" >&2
    exit 1
fi

php -r '
    $result = json_decode(file_get_contents($argv[1]), true, flags: JSON_THROW_ON_ERROR);
    if (($result["ok"] ?? false) !== true) {
        fwrite(STDERR, "Remote release returned an error.\n");
        exit(1);
    }
    echo "Remote migrations and cache rebuild completed.\n";
' "$RELEASE_RESULT"

for path in / /autobox /admin/login; do
    status="$(curl -sS --connect-timeout 15 --max-time 30 -o /dev/null -w '%{http_code}' "$SITE_URL$path")"
    [[ "$status" == "200" ]] || { echo "Health check failed: $path returned $status" >&2; exit 1; }
done

: > "$SFTP_BATCH"
printf '%s\n' "-mkdir $(sftp_quote "$REMOTE_ROOT/storage/app/deploy")" >> "$SFTP_BATCH"
printf '%s\n' "put $(sftp_quote "$LOCAL_MANIFEST") $(sftp_quote "$REMOTE_MANIFEST")" >> "$SFTP_BATCH"
run_sftp "$SFTP_BATCH"

echo "Deployment completed: $SITE_URL"
echo "Backup: $BACKUP_DIR"

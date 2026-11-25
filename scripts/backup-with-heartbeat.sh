#!/bin/sh

task_status=0
(unset HEARTBEAT_TOKEN; exec /usr/bin/python3 "$(dirname "$0")/backup-sftp.py") || task_status=$?

if [ "$task_status" -eq 0 ]; then
    signal=success
else
    signal=failure
fi

if [ -z "${HEARTBEAT_TOKEN:-}" ]; then
    printf '%s\n' 'Не задан HEARTBEAT_TOKEN' >&2
elif signal_id=$(cat /proc/sys/kernel/random/uuid); then
    if printf 'Authorization: Bearer %s\nIdempotency-Key: %s\n' "$HEARTBEAT_TOKEN" "$signal_id" |
        curl --silent --show-error --fail --retry 3 --max-time 10 --output /dev/null \
            -X POST -H @- "https://zhivlisite.ru/api/heartbeats/10/$signal"; then
        printf 'Heartbeat: отправлен сигнал %s\n' "$signal"
    fi
fi

exit "$task_status"

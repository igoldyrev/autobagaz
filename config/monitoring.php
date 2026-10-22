<?php

return [
    'min_disk_free_bytes' => 1024 ** 3,
    'backup_max_age_seconds' => 36 * 3600,
    'backup_status_path' => storage_path('app/deploy/last-verified-backup.json'),
];

<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Throwable;

class MonitoringInfrastructure
{
    public function snapshot(): array
    {
        $free = $this->freeDiskBytes();
        $minimum = config('monitoring.min_disk_free_bytes');
        $disk = [
            'scope' => 'filesystem',
            'free_bytes' => $free,
            'min_free_bytes' => $minimum,
            'state' => $free === null ? 'unknown' : ($free < $minimum ? 'low' : 'ok'),
        ];
        $backup = $this->backup();

        return [
            'state' => $disk['state'] === 'ok' && $backup['state'] === 'ok' ? 'ok' : 'degraded',
            'disk' => $disk,
            'backup' => $backup,
        ];
    }

    protected function freeDiskBytes(): ?int
    {
        $free = @disk_free_space(storage_path());

        return $free === false ? null : (int) $free;
    }

    private function backup(): array
    {
        $path = config('monitoring.backup_status_path');
        $backup = [
            'state' => 'never',
            'snapshot_at' => null,
            'last_verified_at' => null,
            'max_age_seconds' => config('monitoring.backup_max_age_seconds'),
        ];
        if (! is_file($path)) {
            return $backup;
        }

        try {
            $data = json_decode(file_get_contents($path), true, 16, JSON_THROW_ON_ERROR);
            foreach (['snapshot_at', 'last_verified_at'] as $key) {
                if (! is_string($data[$key] ?? null) || ! preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:Z|[+-]\d{2}:\d{2})$/', $data[$key])) {
                    throw new \RuntimeException('Invalid backup timestamp.');
                }
            }
            $snapshot = CarbonImmutable::parse($data['snapshot_at']);
            $verified = CarbonImmutable::parse($data['last_verified_at']);
            if ($snapshot->greaterThan($verified) || $verified->greaterThan(now()->addMinute())) {
                throw new \RuntimeException('Invalid backup timestamp order.');
            }
            $backup['snapshot_at'] = $snapshot->utc()->toIso8601String();
            $backup['last_verified_at'] = $verified->utc()->toIso8601String();
            $backup['state'] = $snapshot->lessThanOrEqualTo(now()->subSeconds($backup['max_age_seconds'])) ? 'stale' : 'ok';
        } catch (Throwable) {
            $backup['state'] = 'invalid';
        }

        return $backup;
    }
}

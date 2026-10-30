<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class MonitoringHeartbeats
{
    public const TASKS = [
        'scheduler' => 180,
        'dispatch_notifications' => 180,
        'notification_monitor' => 900,
        'expire_reservations' => 180,
    ];

    public function succeed(string $task): void
    {
        if (! array_key_exists($task, self::TASKS)) {
            throw new InvalidArgumentException('Unknown monitoring task.');
        }

        DB::table('monitoring_heartbeats')->updateOrInsert(
            ['task' => $task],
            ['last_succeeded_at' => now()->utc()],
        );
    }

    /** @return array{state: string, tasks: array<string, array{last_succeeded_at: ?string, max_age_seconds: int, state: string}>} */
    public function snapshot(): array
    {
        $timestamps = DB::table('monitoring_heartbeats')->pluck('last_succeeded_at', 'task');
        $tasks = [];
        foreach (self::TASKS as $task => $maxAge) {
            $last = isset($timestamps[$task]) ? CarbonImmutable::parse($timestamps[$task], 'UTC') : null;
            $tasks[$task] = [
                'last_succeeded_at' => $last?->toIso8601String(),
                'max_age_seconds' => $maxAge,
                'state' => $last === null ? 'never' : ($last->lessThanOrEqualTo(now()->subSeconds($maxAge)) ? 'stale' : 'ok'),
            ];
        }

        return [
            'state' => collect($tasks)->contains(fn ($task) => $task['state'] !== 'ok') ? 'degraded' : 'ok',
            'tasks' => $tasks,
        ];
    }
}

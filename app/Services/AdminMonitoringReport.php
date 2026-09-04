<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use InvalidArgumentException;

class AdminMonitoringReport
{
    /** @var list<string> */
    private const CHANGE_ACTIONS = [
        AdminActivityLog::ACTION_CREATED,
        AdminActivityLog::ACTION_UPDATED,
        AdminActivityLog::ACTION_DELETED,
        AdminActivityLog::ACTION_SESSIONS_TERMINATED,
    ];

    /** @return array<string, mixed> */
    public function build(?string $date = null, int $changesLimit = 3): array
    {
        $timezone = config('app.display_timezone');
        $targetDate = $this->targetDate($date, $timezone);
        $start = $targetDate->startOfDay();
        $end = $targetDate->endOfDay();
        $changesLimit = min(max($changesLimit, 1), 10);

        $administrators = User::query()
            ->where('is_admin', true)
            ->orderByRaw('last_seen_at IS NULL')
            ->orderByDesc('last_seen_at')
            ->orderBy('name')
            ->get(['id', 'name', 'role', 'last_login_at', 'last_seen_at'])
            ->map(function (User $administrator) use ($start, $end, $changesLimit): array {
                $changes = AdminActivityLog::query()
                    ->where('user_id', $administrator->id)
                    ->whereIn('action', self::CHANGE_ACTIONS)
                    ->whereBetween('created_at', [$start->utc(), $end->utc()]);

                return [
                    'id' => $administrator->id,
                    'name' => $administrator->name,
                    'role' => $administrator->role ?: User::ROLE_ADMINISTRATOR,
                    'role_label' => $administrator->role
                        ? $administrator->roleLabel()
                        : User::roleLabels()[User::ROLE_ADMINISTRATOR],
                    'last_login_at' => $this->timestamp($administrator->last_login_at),
                    'last_seen_at' => $this->timestamp($administrator->last_seen_at),
                    'changes_count' => (clone $changes)->count(),
                    'changes' => (clone $changes)
                        ->latest('created_at')
                        ->limit($changesLimit)
                        ->get(['action', 'description', 'subject_type', 'subject_name', 'created_at'])
                        ->map(fn (AdminActivityLog $activity): array => [
                            'action' => $activity->action,
                            'description' => $activity->description,
                            'subject_type' => $activity->subject_type,
                            'subject_name' => $activity->subject_name,
                            'occurred_at' => $this->timestamp($activity->created_at),
                        ])
                        ->all(),
                ];
            })
            ->all();

        return [
            'state' => 'ok',
            'generated_at' => CarbonImmutable::now($timezone)->toIso8601String(),
            'period' => [
                'date' => $targetDate->toDateString(),
                'timezone' => $timezone,
                'starts_at' => $start->toIso8601String(),
                'ends_at' => $end->toIso8601String(),
            ],
            'site' => [
                'available' => true,
                'database' => 'ok',
            ],
            'administrators' => $administrators,
        ];
    }

    private function targetDate(?string $date, string $timezone): CarbonImmutable
    {
        if ($date === null) {
            return CarbonImmutable::now($timezone);
        }

        $parsed = CarbonImmutable::createFromFormat('!Y-m-d', $date, $timezone);
        if ($parsed === false || $parsed->toDateString() !== $date) {
            throw new InvalidArgumentException('Date must use YYYY-MM-DD format.');
        }

        return $parsed;
    }

    private function timestamp(?CarbonInterface $timestamp): ?string
    {
        return $timestamp?->toImmutable()->utc()->toIso8601String();
    }
}

<?php

namespace App\Services;

use App\Models\OrderNotification;
use Illuminate\Support\Facades\DB;

class OrderNotificationStatus
{
    /** @return array{pending: int, queued: int, failed_notifications: int, overdue: int, failed_jobs: int|null} */
    public function build(int $maxAge = 15): array
    {
        $unsent = OrderNotification::query()->whereNull('sent_at');

        return [
            'pending' => (clone $unsent)->whereNull('queued_at')->count(),
            'queued' => (clone $unsent)->whereNotNull('queued_at')->whereNull('failed_at')->count(),
            'failed_notifications' => (clone $unsent)->whereNotNull('failed_at')->count(),
            'overdue' => (clone $unsent)->where('created_at', '<=', now()->subMinutes($maxAge))->count(),
            'failed_jobs' => config('queue.failed.driver') === 'database-uuids'
                ? DB::connection(config('queue.failed.database'))->table(config('queue.failed.table'))->count()
                : null,
        ];
    }

    /** @param array{failed_notifications: int, overdue: int, failed_jobs: int|null} $status */
    public function needsAttention(array $status): bool
    {
        return $status['failed_notifications'] > 0 || $status['overdue'] > 0 || $status['failed_jobs'] > 0;
    }
}

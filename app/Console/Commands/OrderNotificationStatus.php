<?php

namespace App\Console\Commands;

use App\Models\OrderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OrderNotificationStatus extends Command
{
    protected $signature = 'orders:notification-status {--max-age=15 : Maximum unsent notification age in minutes}';

    protected $description = 'Report notification backlog and failed jobs; exit nonzero when attention is needed';

    public function handle(): int
    {
        $maxAge = filter_var($this->option('max-age'), FILTER_VALIDATE_INT);
        if ($maxAge === false || $maxAge < 1) {
            $this->components->error('The --max-age value must be a positive integer.');

            return self::INVALID;
        }

        $unsent = OrderNotification::query()->whereNull('sent_at');
        $failedJobs = config('queue.failed.driver') === 'database-uuids'
            ? DB::connection(config('queue.failed.database'))->table(config('queue.failed.table'))->count()
            : null;
        $payload = [
            'pending' => (clone $unsent)->whereNull('queued_at')->count(),
            'queued' => (clone $unsent)->whereNotNull('queued_at')->whereNull('failed_at')->count(),
            'failed_notifications' => (clone $unsent)->whereNotNull('failed_at')->count(),
            'overdue' => (clone $unsent)->where('created_at', '<=', now()->subMinutes($maxAge))->count(),
            'failed_jobs' => $failedJobs,
        ];
        $this->line(json_encode($payload, JSON_THROW_ON_ERROR));

        return $payload['failed_notifications'] || $payload['overdue'] || $failedJobs
            ? self::FAILURE : self::SUCCESS;
    }
}

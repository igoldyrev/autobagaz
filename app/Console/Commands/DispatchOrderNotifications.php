<?php

namespace App\Console\Commands;

use App\Models\OrderNotification;
use App\Services\MonitoringHeartbeats;
use App\Services\OrderNotifications;
use Illuminate\Console\Command;

class DispatchOrderNotifications extends Command
{
    protected $signature = 'orders:dispatch-notifications {--limit=100 : Maximum pending notifications to dispatch}';

    protected $description = 'Queue durable order and callback notifications that have not been queued yet';

    public function handle(OrderNotifications $notifications): int
    {
        $limit = filter_var($this->option('limit'), FILTER_VALIDATE_INT);
        if ($limit === false || $limit < 1 || $limit > 10000) {
            $this->components->error('The --limit value must be between 1 and 10000.');

            return self::INVALID;
        }

        $count = $notifications->dispatchPending($limit);
        $this->components->info("Dispatched: {$count}");

        if (OrderNotification::query()->whereNull('queued_at')->whereNull('sent_at')->exists()) {
            return self::FAILURE;
        }

        app(MonitoringHeartbeats::class)->succeed('dispatch_notifications');

        return self::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Services\OrderNotificationStatus as NotificationStatus;
use Illuminate\Console\Command;

class OrderNotificationStatus extends Command
{
    protected $signature = 'orders:notification-status {--max-age=15 : Maximum unsent notification age in minutes}';

    protected $description = 'Report notification backlog and failed jobs; exit nonzero when attention is needed';

    public function handle(NotificationStatus $status): int
    {
        $maxAge = filter_var($this->option('max-age'), FILTER_VALIDATE_INT);
        if ($maxAge === false || $maxAge < 1) {
            $this->components->error('The --max-age value must be a positive integer.');

            return self::INVALID;
        }

        $payload = $status->build($maxAge);
        $this->line(json_encode($payload, JSON_THROW_ON_ERROR));

        return $status->needsAttention($payload)
            ? self::FAILURE : self::SUCCESS;
    }
}

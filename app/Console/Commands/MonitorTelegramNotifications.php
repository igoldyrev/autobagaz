<?php

namespace App\Console\Commands;

use App\Services\MonitoringHeartbeats;
use App\Services\OrderNotificationStatus;
use App\Services\TelegramNotificationMonitor;
use App\Services\TelegramNotifications;
use App\Services\TelegramSiteErrors;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class MonitorTelegramNotifications extends Command
{
    protected $signature = 'telegram:monitor-notifications';

    protected $description = 'Send site error reports and notification failure/recovery alerts directly to Telegram';

    public function handle(TelegramNotificationMonitor $monitor, TelegramNotifications $telegram, OrderNotificationStatus $status, TelegramSiteErrors $siteErrors): int
    {
        $failed = false;
        foreach ([fn () => $monitor->check($telegram, $status), fn () => $siteErrors->sendPending($telegram)] as $check) {
            try {
                $check();
            } catch (Throwable $exception) {
                Log::error('Telegram monitoring failed.', ['exception_class' => $exception::class]);
                $failed = true;
            }
        }
        if ($failed) {
            $this->components->error('Telegram monitoring failed. Check bot settings, connectivity and application logs.');

            return self::FAILURE;
        }

        app(MonitoringHeartbeats::class)->succeed('notification_monitor');

        return self::SUCCESS;
    }
}

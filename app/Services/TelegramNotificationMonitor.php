<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use RuntimeException;
use Throwable;

class TelegramNotificationMonitor
{
    public function check(TelegramNotifications $telegram, OrderNotificationStatus $status): void
    {
        $recipients = $telegram->alertRecipients();
        if ($recipients === []) {
            return;
        }

        try {
            $report = $status->build();
            $unhealthy = $status->needsAttention($report);
            $text = "Автобагаж: обнаружен сбой уведомлений\n"
                ."Ожидают постановки: {$report['pending']}\nВ очереди: {$report['queued']}\n"
                ."Задержаны более 15 минут: {$report['overdue']}\n"
                ."Неудачные уведомления: {$report['failed_notifications']}\n"
                .'Failed jobs: '.($report['failed_jobs'] ?? 'нет данных');
        } catch (Throwable) {
            $unhealthy = true;
            $text = 'Автобагаж: не удалось проверить уведомления. Проверьте доступность БД и журнал приложения.';
        }

        $failed = false;
        foreach ($recipients as $recipient) {
            $key = 'telegram.notification-monitor.'.hash('sha256', config('services.telegram.bot_token').'|'.$recipient);
            $previous = Cache::get($key);
            // Notify once on failure and once on recovery; never flood a healthy chat.
            try {
                if ($unhealthy && $previous !== 'failed') {
                    $telegram->send($recipient, $text);
                    Cache::forever($key, 'failed');
                } elseif (! $unhealthy && $previous === 'failed') {
                    $telegram->send($recipient, 'Автобагаж: отправка уведомлений восстановлена. Ошибок и задержанных заданий нет.');
                    Cache::forever($key, 'ok');
                }
            } catch (Throwable) {
                $failed = true;
            }
        }

        if ($failed) {
            throw new RuntimeException('Some Telegram alert recipients could not be reached.');
        }
    }
}

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
            $text = "🔴 Автобагаж: сбой фоновых задач или отправки писем\n"
                ."Обнаружены ошибки заданий или письма, ожидающие отправки более 15 минут.\n\n"
                ."Писем ожидают постановки в очередь: {$report['pending']}\n"
                ."Писем в очереди: {$report['queued']}\n"
                ."Писем с задержкой более 15 минут: {$report['overdue']}\n"
                ."Писем с ошибкой отправки: {$report['failed_notifications']}\n"
                .'Фоновых заданий с ошибкой: '.($report['failed_jobs'] ?? 'нет данных')."\n\n"
                .'Что проверить: обработчик очереди, подключение к почтовому серверу и журнал приложения.';
        } catch (Throwable) {
            $unhealthy = true;
            $text = "⚠️ Автобагаж: не удалось проверить отправку писем\n"
                ."Состояние очереди неизвестно. Причина требует проверки журнала.\n\n"
                .'Что проверить: доступность базы данных и журнал приложения.';
        }
        $text .= "\nВремя проверки: ".now()->setTimezone(config('app.display_timezone'))->format('d.m.Y H:i:s')
            .' ('.config('app.display_timezone').')';

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
                    $telegram->send($recipient, "🟢 Автобагаж: проверка уведомлений восстановлена\n"
                        ."Ошибок фоновых заданий и писем с задержкой более 15 минут не обнаружено.\n"
                        .'Время проверки: '.now()->setTimezone(config('app.display_timezone'))->format('d.m.Y H:i:s')
                        .' ('.config('app.display_timezone').')');
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

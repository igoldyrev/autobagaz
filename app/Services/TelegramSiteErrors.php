<?php

namespace App\Services;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class TelegramSiteErrors
{
    private const INCIDENTS_KEY = 'telegram.site-errors';

    private function cache(): Repository
    {
        // File storage remains available when the application's database fails.
        return Cache::store(config('services.telegram.error_cache_store', 'file'));
    }

    public function record(Throwable $exception, ?int $httpStatus = null, ?string $route = null, bool $increment = true): void
    {
        try {
            $cache = $this->cache();
            $file = str_starts_with($exception->getFile(), base_path().DIRECTORY_SEPARATOR)
                ? substr($exception->getFile(), strlen(base_path()) + 1)
                : basename($exception->getFile());
            $exceptionStatus = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : null;
            $fingerprint = hash('sha256', $exception::class.'|'.$file.'|'.$exception->getLine().'|'.$exceptionStatus);
            $cache->lock(self::INCIDENTS_KEY.'.lock', 5)->block(1, function () use ($cache, $exception, $file, $fingerprint, $httpStatus, $route, $increment, $exceptionStatus) {
                $incidents = $cache->get(self::INCIDENTS_KEY, []);
                $incidents = array_filter($incidents, fn ($incident) => $incident['last_timestamp'] > now()->subDay()->timestamp);
                $previous = $incidents[$fingerprint] ?? null;
                $incidents[$fingerprint] = [
                    'class' => $exception::class,
                    'file' => $file,
                    'line' => $exception->getLine(),
                    'first_at' => $previous['first_at'] ?? now()->toIso8601String(),
                    'last_at' => now()->toIso8601String(),
                    'last_timestamp' => now()->timestamp,
                    'count' => ($previous['count'] ?? 0) + ($increment || ! $previous ? 1 : 0),
                    'http_status' => $httpStatus ?? $exceptionStatus ?? ($previous['http_status'] ?? null),
                    'route' => $route ?? ($previous['route'] ?? null),
                ];
                // Bound storage even during an error storm; preserve the latest incidents.
                uasort($incidents, fn ($a, $b) => strcmp($a['last_at'], $b['last_at']));
                $cache->put(self::INCIDENTS_KEY, array_slice($incidents, -100, null, true), now()->addDay());
            });
        } catch (Throwable) {
            // Error reporting must never replace the original error or recurse.
        }
    }

    /** @return array{groups: int, occurrences: int, last_at: string|null} */
    public function snapshot(): array
    {
        $incidents = array_filter($this->cache()->get(self::INCIDENTS_KEY, []),
            fn ($incident) => $incident['last_timestamp'] > now()->subDay()->timestamp);

        return [
            'groups' => count($incidents),
            'occurrences' => array_sum(array_column($incidents, 'count')),
            'last_at' => $incidents === [] ? null : max(array_column($incidents, 'last_at')),
        ];
    }

    public function sendPending(TelegramNotifications $telegram): void
    {
        $recipients = $telegram->alertRecipients();
        if ($recipients === []) {
            return;
        }
        $cache = $this->cache();
        $failed = false;
        foreach ($cache->get(self::INCIDENTS_KEY, []) as $fingerprint => $incident) {
            if ($incident['last_timestamp'] <= now()->subDay()->timestamp) {
                continue;
            }
            foreach ($recipients as $recipient) {
                $key = 'telegram.site-error-delivered.'.hash('sha256', config('services.telegram.bot_token').'|'.$recipient.'|'.$fingerprint);
                $sent = $cache->get($key);
                if ($sent && ($sent['count'] >= $incident['count'] || $sent['at'] > now()->subHour()->timestamp)) {
                    continue;
                }
                $httpContext = isset($incident['http_status']) ? 'HTTP: '.$incident['http_status']."\n" : '';
                $routeContext = isset($incident['route']) ? 'Страница: '.$incident['route']."\n" : '';
                $text = "Автобагаж: ошибка сайта\n"
                    .$httpContext.$routeContext
                    ."Тип: {$incident['class']}\nФайл: {$incident['file']}:{$incident['line']}\n"
                    ."Первое событие: {$incident['first_at']}\nПоследнее событие: {$incident['last_at']}\n"
                    ."Повторений: {$incident['count']}\nПодробности — в серверном журнале приложения.";
                try {
                    $telegram->send($recipient, $text);
                    $cache->put($key, ['count' => $incident['count'], 'at' => now()->timestamp], now()->addDay());
                } catch (Throwable) {
                    $failed = true;
                }
            }
        }
        if ($failed) {
            throw new RuntimeException('Some Telegram site error reports could not be delivered.');
        }
    }
}

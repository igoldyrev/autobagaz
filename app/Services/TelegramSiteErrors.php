<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use PDOException;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
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
            $logged = false;
            foreach ($recipients as $recipient) {
                $key = 'telegram.site-error-delivered.'.hash('sha256', config('services.telegram.bot_token').'|'.$recipient.'|'.$fingerprint);
                $sent = $cache->get($key);
                if ($sent && ($sent['count'] >= $incident['count'] || $sent['at'] > now()->subHour()->timestamp)) {
                    continue;
                }
                $text = $this->message($incident, $fingerprint);
                if (! $logged) {
                    try {
                        // Also covers incidents cached before searchable codes were introduced.
                        Log::error('Site error recorded.', [
                            'site_error_code' => $this->errorCode($fingerprint),
                            'exception_class' => $incident['class'],
                            'file' => $incident['file'],
                            'line' => $incident['line'],
                            'http_status' => $incident['http_status'],
                            'first_at' => $incident['first_at'],
                            'last_at' => $incident['last_at'],
                        ]);
                    } catch (Throwable) {
                        // A broken log must not prevent delivery of the alert.
                    }
                    $logged = true;
                }
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

    private function errorCode(string $fingerprint): string
    {
        return 'SITE-'.strtoupper(substr($fingerprint, 0, 12));
    }

    private function message(array $incident, string $fingerprint): string
    {
        $route = $incident['route'] ?? '';
        $heading = match (true) {
            $route === 'POST /checkout' => 'ошибка при оформлении заказа',
            str_starts_with($route, 'GET /checkout') => 'ошибка при открытии страницы заказа',
            str_contains($route, ' /checkout/') => 'ошибка при обработке заказа',
            str_contains($route, ' /cart') => 'ошибка в корзине',
            $route === 'POST /callback' => 'ошибка при отправке заявки на звонок',
            $route === 'POST /prokat' => 'ошибка при отправке заявки на прокат',
            str_contains($route, ' /admin/') => 'ошибка в панели управления',
            default => 'ошибка сайта',
        };
        [$description, $advice] = match (true) {
            is_a($incident['class'], QueryException::class, true),
            is_a($incident['class'], PDOException::class, true) => [
                'Не удалось выполнить операцию с базой данных.',
                'Проверьте подключение к базе данных и запись в журнале приложения.',
            ],
            is_a($incident['class'], TransportExceptionInterface::class, true) => [
                'Не удалось передать письмо почтовому серверу.',
                'Проверьте доступность почтового сервера, настройки отправки и журнал приложения.',
            ],
            is_a($incident['class'], ConnectionException::class, true) => [
                'Не удалось выполнить запрос к внешнему сервису.',
                'Проверьте доступность внешнего сервиса и журнал приложения.',
            ],
            default => [
                'Произошла серверная ошибка. Причина пока не определена.',
                'Найдите запись в журнале приложения по коду ошибки ниже.',
            ],
        };
        $timezone = config('app.display_timezone');
        $first = CarbonImmutable::parse($incident['first_at'])->setTimezone($timezone)->format('d.m.Y H:i:s');
        $last = CarbonImmutable::parse($incident['last_at'])->setTimezone($timezone)->format('d.m.Y H:i:s');
        $http = isset($incident['http_status']) ? 'HTTP: '.$incident['http_status']."\n" : '';
        $where = $route !== '' ? 'Страница: '.$route : 'Место ошибки: контекст страницы не определён';

        return '🔴 Автобагаж: '.$heading."\n"
            .$description."\n\n".$where."\n".$http
            ."Зафиксировано: {$incident['count']}\n"
            .'Первый случай: '.$first."\nПоследний случай: ".$last.' ('.$timezone.")\n\n"
            .'Что проверить: '.$advice."\nКод ошибки: ".$this->errorCode($fingerprint);
    }
}

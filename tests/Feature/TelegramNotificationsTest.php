<?php

namespace Tests\Feature;

use App\Mail\OrderConfirmation;
use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\OrderNotification;
use App\Services\OrderNotifications;
use App\Services\OrderNotificationStatus;
use App\Services\TelegramNotifications;
use App\Services\TelegramSiteErrors;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Route;
use RuntimeException;
use Tests\TestCase;

class TelegramNotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'services.telegram.bot_token' => 'test-bot-token',
            'services.telegram.proxy_url' => null,
            'services.telegram.alert_chat_ids' => '303',
            'services.telegram.error_cache_store' => 'array',
            'orders.notification_emails' => 'manager@example.test',
        ]);
        Http::preventStrayRequests();
        Mail::fake();
    }

    public function test_orders_only_send_email_even_when_telegram_alerts_are_configured(): void
    {
        app(OrderNotifications::class)->recordOrder($this->order());
        app(OrderNotifications::class)->dispatchPending();
        $this->assertDatabaseCount('order_notifications', 2);
        Mail::assertSent(OrderCreated::class, 1);
        Mail::assertSent(OrderConfirmation::class, 1);
        Http::assertNothingSent();
    }

    public function test_disabled_telegram_does_not_change_email_notifications(): void
    {
        config(['services.telegram.bot_token' => null]);
        app(OrderNotifications::class)->recordOrder($this->order());
        app(OrderNotifications::class)->dispatchPending();
        $this->assertDatabaseCount('order_notifications', 2);
        Http::assertNothingSent();
    }

    public function test_monitor_sends_failure_and_recovery_once_without_using_the_queue(): void
    {
        Queue::fake();
        Http::swap(new Factory);
        Http::preventStrayRequests();
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true, 'result' => []])]);
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertNothingSent();
        $notification = OrderNotification::query()->create([
            'type' => 'order_confirmation', 'recipient' => '101', 'failed_at' => now(), 'queued_at' => now(),
        ]);
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertSentCount(1);
        Http::assertSent(fn ($request) => $request['chat_id'] === '303' && str_contains($request['text'], 'сбой'));
        $notification->update(['sent_at' => now(), 'failed_at' => null]);
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertSentCount(2);
        Http::assertSent(fn ($request) => str_contains($request['text'], 'восстановлена'));
        Queue::assertNothingPushed();
    }

    public function test_failed_alert_recipient_is_retried_without_blocking_other_recipients(): void
    {
        config(['services.telegram.alert_chat_ids' => '303,404']);
        OrderNotification::query()->create(['type' => 'order_confirmation', 'recipient' => '101', 'failed_at' => now()]);
        Http::fake(fn ($request) => $request['chat_id'] === '303'
            ? Http::response(['ok' => false], 403)
            : Http::response(['ok' => true, 'result' => []]));
        $this->artisan('telegram:monitor-notifications')->assertFailed();
        Http::assertSent(fn ($request) => $request['chat_id'] === '404');

        Http::swap(new Factory);
        Http::preventStrayRequests();
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true, 'result' => []])]);
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertSent(fn ($request) => $request['chat_id'] === '303');
        Http::assertNotSent(fn ($request) => $request['chat_id'] === '404');
    }

    public function test_http_exception_does_not_expose_bot_token_in_failed_job_exception(): void
    {
        Http::fake(fn () => throw new ConnectionException('https://api.telegram.org/bottest-bot-token/sendMessage via socks5h://user:proxy-password@proxy.example:1080'));
        try {
            app(TelegramNotifications::class)->send('101', 'test');
            $this->fail('Expected a sanitized exception.');
        } catch (RuntimeException $exception) {
            $this->assertSame('Telegram API connection failed.', $exception->getMessage());
            $this->assertNull($exception->getPrevious());
            $this->assertStringNotContainsString('test-bot-token', (string) $exception);
            $this->assertStringNotContainsString('proxy-password', (string) $exception);
        }
    }

    public function test_database_failure_is_reported_directly_without_exception_details(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true, 'result' => []])]);
        $this->mock(OrderNotificationStatus::class, function ($mock) {
            $mock->shouldReceive('build')->once()->andThrow(new RuntimeException('private database connection details'));
        });
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertSent(fn ($request) => str_contains($request['text'], 'не удалось проверить')
            && ! str_contains($request['text'], 'private database connection details'));
    }

    public function test_recent_chats_return_only_chat_metadata(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true, 'result' => [
            ['message' => ['text' => 'private text', 'chat' => ['id' => 101, 'first_name' => 'Иван', 'type' => 'private']]],
            ['message' => ['chat' => ['id' => 101, 'first_name' => 'Иван', 'type' => 'private']]],
        ]])]);
        $this->assertSame([['id' => '101', 'name' => 'Иван', 'type' => 'private']], app(TelegramNotifications::class)->recentChats());
    }

    public function test_reported_site_errors_are_sent_by_scheduler_without_private_details(): void
    {
        Queue::fake();
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true, 'result' => []])]);
        report(new RuntimeException('private exception message, token and customer data'));
        Http::assertNothingSent();
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertSentCount(1);
        Http::assertSent(fn ($request) => str_contains($request['text'], 'ошибка сайта')
            && str_contains($request['text'], RuntimeException::class)
            && ! str_contains($request['text'], 'private exception message'));
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertSentCount(1);
        Queue::assertNothingPushed();
    }

    public function test_repeated_site_errors_are_grouped_and_only_resent_after_cooldown(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true, 'result' => []])]);
        $errors = app(TelegramSiteErrors::class);
        $exception = new RuntimeException('private detail');
        $errors->record($exception);
        $errors->record($exception);
        $errors->sendPending(app(TelegramNotifications::class));
        Http::assertSentCount(1);
        Http::assertSent(fn ($request) => str_contains($request['text'], 'Повторений: 2'));
        $errors->record($exception);
        $errors->sendPending(app(TelegramNotifications::class));
        Http::assertSentCount(1);
        $this->travel(61)->minutes();
        $errors->sendPending(app(TelegramNotifications::class));
        Http::assertSentCount(2);
        Http::assertSent(fn ($request) => str_contains($request['text'], 'Повторений: 3'));
        $this->travel(61)->minutes();
        $errors->sendPending(app(TelegramNotifications::class));
        Http::assertSentCount(2);
    }

    public function test_failed_site_error_delivery_is_retried_and_other_recipients_still_receive_it(): void
    {
        config(['services.telegram.alert_chat_ids' => '303,404']);
        app(TelegramSiteErrors::class)->record(new RuntimeException('private detail'));
        Http::fake(fn ($request) => $request['chat_id'] === '303'
            ? Http::response(['ok' => false], 403)
            : Http::response(['ok' => true, 'result' => []]));
        $this->artisan('telegram:monitor-notifications')->assertFailed();
        Http::assertSent(fn ($request) => $request['chat_id'] === '404');
        Http::swap(new Factory);
        Http::preventStrayRequests();
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true, 'result' => []])]);
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertSentCount(1);
        Http::assertSent(fn ($request) => $request['chat_id'] === '303');
    }

    public function test_abort_server_errors_are_reported_with_status_and_safe_route_template(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true, 'result' => []])]);
        Route::get('/test-monitor/server-error/{status}/{secret}', fn (int $status) => abort($status, 'private error details'));
        foreach ([500, 502, 503, 504, 599] as $status) {
            $this->get('/test-monitor/server-error/'.$status.'/private-value?token=private-token')->assertStatus($status);
        }
        Http::assertNothingSent();
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertSentCount(5);
        foreach ([500, 502, 503, 504, 599] as $status) {
            Http::assertSent(fn ($request) => str_contains($request['text'], 'HTTP: '.$status)
                && str_contains($request['text'], 'GET /test-monitor/server-error/{status}/{secret}')
                && ! str_contains($request['text'], 'private-value')
                && ! str_contains($request['text'], 'private-token')
                && ! str_contains($request['text'], 'private error details'));
        }
    }

    public function test_server_error_responses_without_exceptions_are_reported(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true, 'result' => []])]);
        Route::get('/test-monitor/error-response', fn () => response('private body', 503));
        $this->get('/test-monitor/error-response')->assertStatus(503);
        $this->assertSame(1, app(TelegramSiteErrors::class)->snapshot()['occurrences']);
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertSentCount(1);
        Http::assertSent(fn ($request) => str_contains($request['text'], 'HTTP: 503')
            && ! str_contains($request['text'], 'private body'));
    }

    public function test_unhandled_page_exceptions_are_counted_once_and_include_http_status(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true, 'result' => []])]);
        Route::get('/test-monitor/exception', fn () => throw new RuntimeException('private exception'));
        $this->get('/test-monitor/exception')->assertStatus(500);
        $this->assertSame(1, app(TelegramSiteErrors::class)->snapshot()['occurrences']);
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertSentCount(1);
        Http::assertSent(fn ($request) => str_contains($request['text'], 'HTTP: 500')
            && str_contains($request['text'], RuntimeException::class));
    }

    public function test_client_errors_and_successful_pages_do_not_generate_alerts(): void
    {
        Route::get('/test-monitor/status/{status}', fn (int $status) => abort($status));
        Route::get('/test-monitor/ok', fn () => response('ok'));
        $this->get('/test-monitor/ok')->assertOk();
        foreach ([400, 401, 403, 404, 419, 422, 429] as $status) {
            $this->get('/test-monitor/status/'.$status)->assertStatus($status);
        }
        $this->assertSame(0, app(TelegramSiteErrors::class)->snapshot()['occurrences']);
        $this->artisan('telegram:monitor-notifications')->assertSuccessful();
        Http::assertNothingSent();
    }

    public function test_proxy_is_applied_only_to_telegram_requests(): void
    {
        $proxy = 'socks5h://user:proxy-password@proxy.example:1080';
        config(['services.telegram.proxy_url' => $proxy]);
        $observed = [];
        Http::fake(function ($request, $options) use (&$observed) {
            $observed[$request->url()] = $options['proxy'] ?? null;

            return Http::response(['ok' => true, 'result' => []]);
        });
        app(TelegramNotifications::class)->send('303', 'test');
        Http::get('https://example.test/health');
        $this->assertSame($proxy, $observed['https://api.telegram.org/bottest-bot-token/sendMessage']);
        $this->assertNotSame($proxy, $observed['https://example.test/health']);
    }

    private function order(): Order
    {
        $order = Order::query()->create([
            'number' => 'AB-000001', 'customer_name' => 'Иван', 'phone' => '+79001234567',
            'email' => 'buyer@example.test', 'delivery_method' => 'pickup', 'total' => 10000,
        ]);
        $order->items()->create(['product_name' => 'Автобокс', 'unit_price' => 10000, 'quantity' => 1, 'total' => 10000]);

        return $order;
    }
}

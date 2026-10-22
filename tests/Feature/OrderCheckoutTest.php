<?php

namespace Tests\Feature;

use App\Http\Middleware\ResolveVehicleConfiguration;
use App\Jobs\SendOrderNotification;
use App\Mail\CallbackRequested;
use App\Mail\OrderConfirmation;
use App\Mail\OrderCreated;
use App\Models\CallbackRequest;
use App\Models\InstallationService;
use App\Models\Order;
use App\Models\OrderNotification;
use App\Models\Product;
use App\Models\User;
use App\Models\VehicleBodyStyle;
use App\Models\VehicleConfiguration;
use App\Models\VehicleGeneration;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleRoofType;
use App\Services\OrderNotifications;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RuntimeException;
use Tests\TestCase;

class OrderCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_add_product_to_cart_and_place_delivery_order(): void
    {
        Mail::fake();
        $product = $this->product();

        $this->post(route('cart.store', $product))
            ->assertRedirect(route('cart.index'));

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee('Оформить заказ');

        $this->post(route('checkout.store'), [
            'checkout_token' => $this->checkoutToken(),
            'customer_name' => 'Иван Петров',
            'phone' => '+7 900 123-45-67',
            'email' => 'ivan@example.com',
            'delivery_method' => 'delivery',
            'delivery_address' => 'Пермь, ул. Пример, 1',
            'comment' => 'Позвонить после 18:00',
        ])->assertRedirect();

        $order = Order::query()->firstOrFail();
        $this->assertSame('AB-000001', $order->number);
        $this->assertSame('delivery', $order->delivery_method);
        $this->assertSame('ivan@example.com', $order->email);
        $this->assertSame('Пермь, ул. Пример, 1', $order->delivery_address);
        $this->assertSame('10000.00', $order->total);
        $this->assertSame($product->name, $order->items->sole()->product_name);
        $this->assertSame('10000.00', $order->items->sole()->unit_price);
        Mail::assertSent(OrderCreated::class, fn (OrderCreated $mail) => $mail->order->is($order));
        Mail::assertSent(OrderConfirmation::class, fn (OrderConfirmation $mail) => $mail->order->is($order));
        $this->assertEmpty(session('cart.items', []));
    }

    public function test_delivery_address_is_required_for_delivery(): void
    {
        $this->post(route('cart.store', $this->product()));
        $checkoutToken = $this->checkoutToken();

        $this->from(route('checkout.create'))
            ->post(route('checkout.store'), [
                'checkout_token' => $checkoutToken,
                'customer_name' => 'Иван Петров',
                'phone' => '+7 900 123-45-67',
                'email' => 'ivan@example.com',
                'delivery_method' => 'delivery',
            ])
            ->assertRedirect(route('checkout.create'))
            ->assertSessionHasErrors('delivery_address');
    }

    public function test_customer_can_add_installation_service_to_order(): void
    {
        Mail::fake();
        $product = $this->product();
        $service = InstallationService::query()->firstOrFail();
        $this->post(route('cart.store', $product));
        session(['cart.installation_service' => true]);

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee($service->name)
            ->assertSee('12 500 ₽');

        $this->post(route('checkout.store'), [
            'checkout_token' => $this->checkoutToken(),
            'customer_name' => 'Иван Петров',
            'phone' => '+7 900 123-45-67',
            'email' => 'ivan@example.com',
            'delivery_method' => 'pickup',
        ])->assertRedirect();

        $order = Order::query()->firstOrFail();
        $this->assertSame('12500.00', $order->total);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => null,
            'product_name' => $service->name,
            'unit_price' => '2500.00',
            'quantity' => 1,
            'total' => '2500.00',
        ]);
    }

    public function test_customer_can_add_roof_rack_with_installation_service(): void
    {
        $roofRack = $this->product();
        $roofRack->roofRack()->create();
        $service = InstallationService::query()->firstOrFail();

        $this->get(route('products.show', $roofRack))
            ->assertOk()
            ->assertSee($service->name)
            ->assertSee('Добавить установку')
            ->assertSee(route('cart.store', $roofRack));

        $this->post(route('cart.store', $roofRack), ['installation_service' => '1'])
            ->assertRedirect(route('cart.index'));

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee($roofRack->name)
            ->assertSee($service->name);
    }

    public function test_cart_quantity_can_be_updated_without_page_redirect(): void
    {
        $product = $this->product();
        $this->post(route('cart.store', $product));

        $this->patchJson(route('cart.update', $product), ['quantity' => 3])
            ->assertOk()
            ->assertJson([
                'line_total' => 30000,
                'cart_total' => 30000,
                'cart_count' => 3,
            ]);

        $this->assertSame([strval($product->id) => 3], session('cart.items'));
    }

    public function test_cart_shows_recently_viewed_products(): void
    {
        $firstProduct = $this->product();
        $secondProduct = Product::query()->create([
            'name' => 'Просмотренный товар', 'slug' => 'recent-product', 'price' => 15000, 'stock' => 1, 'is_active' => true,
        ]);

        $this->withSession(['recently_viewed_products' => [$secondProduct->id, $firstProduct->id]])
            ->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Товары, просмотренные ранее')
            ->assertSee($secondProduct->name)
            ->assertSee($firstProduct->name);
    }

    public function test_order_keeps_price_snapshot_when_catalog_price_changes(): void
    {
        Mail::fake();
        $product = $this->product();
        $this->post(route('cart.store', $product));
        $product->update(['price' => 12500]);

        $this->post(route('checkout.store'), [
            'checkout_token' => $this->checkoutToken(),
            'customer_name' => 'Иван Петров',
            'phone' => '+7 900 123-45-67',
            'email' => 'ivan@example.com',
            'delivery_method' => 'pickup',
        ]);

        $this->assertSame('12500.00', Order::query()->firstOrFail()->items->sole()->unit_price);
    }

    public function test_administrator_can_process_order(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = Order::query()->create([
            'number' => 'AB-000001', 'customer_name' => 'Иван Петров', 'phone' => '+79001234567', 'email' => 'ivan@example.com',
            'delivery_method' => 'pickup', 'status' => Order::STATUS_NEW, 'total' => 10000,
        ]);

        $this->actingAs($admin)->get(route('admin.orders.index'))
            ->assertOk()->assertSee($order->number)->assertSee('Новый');
        $this->actingAs($admin)->put(route('admin.orders.update', $order), ['status' => Order::STATUS_IN_PROGRESS, 'expected_status' => Order::STATUS_NEW])
            ->assertRedirect(route('admin.orders.show', $order));
        $this->put(route('admin.orders.update', $order), ['status' => Order::STATUS_CONFIRMED, 'expected_status' => Order::STATUS_IN_PROGRESS])
            ->assertRedirect(route('admin.orders.show', $order));

        $this->assertSame(Order::STATUS_CONFIRMED, $order->fresh()->status);
    }

    public function test_checkout_reuses_token_across_tabs_and_refreshes(): void
    {
        $this->post(route('cart.store', $this->product()));
        $token = $this->checkoutToken();

        $this->assertSame($token, $this->checkoutToken());
        $this->get(route('checkout.create'))->assertSee('value="'.$token.'"', false);
    }

    public function test_repeated_submission_returns_existing_order_without_sending_more_emails(): void
    {
        Mail::fake();
        $product = $this->product();
        $this->post(route('cart.store', $product));
        $data = $this->checkoutData($this->checkoutToken());

        $this->post(route('checkout.store'), $data)->assertRedirect();
        $order = Order::query()->sole();

        $this->post(route('checkout.store'), $data)
            ->assertRedirect(route('checkout.success', $order));

        // A request that started concurrently may still contain the original cart.
        $this->withSession(['cart.items' => [(string) $product->id => 1]])
            ->post(route('checkout.store'), $data)
            ->assertRedirect(route('checkout.success', $order));

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 1);
        Mail::assertSent(OrderCreated::class, 1);
        Mail::assertSent(OrderConfirmation::class, 1);
    }

    public function test_new_checkout_after_completed_order_gets_new_token(): void
    {
        Mail::fake();
        $product = $this->product();
        $this->post(route('cart.store', $product));
        $firstToken = $this->checkoutToken();
        $this->post(route('checkout.store'), $this->checkoutData($firstToken))->assertRedirect();

        $this->post(route('cart.store', $product));
        $secondToken = $this->checkoutToken();
        $this->assertNotSame($firstToken, $secondToken);

        $this->post(route('checkout.store'), $this->checkoutData($firstToken))
            ->assertSessionHasErrors('checkout_token');
        $this->assertDatabaseCount('orders', 1);

        $this->post(route('checkout.store'), $this->checkoutData($secondToken))->assertRedirect();
        $this->assertDatabaseCount('orders', 2);
    }

    public function test_checkout_requires_token_issued_to_current_session(): void
    {
        Mail::fake();
        $this->post(route('cart.store', $this->product()));
        $token = $this->checkoutToken();

        foreach ([null, 'invalid-token', (string) Str::uuid()] as $invalidToken) {
            $data = $this->checkoutData($token);
            $data['checkout_token'] = $invalidToken;
            $this->post(route('checkout.store'), $data)->assertSessionHasErrors('checkout_token');
        }

        $this->withSession(['checkout.token' => (string) Str::uuid()])
            ->post(route('checkout.store'), $this->checkoutData($token))
            ->assertSessionHasErrors('checkout_token');

        $this->assertDatabaseCount('orders', 0);
        Mail::assertNothingOutgoing();
    }

    public function test_invalid_order_can_be_corrected_without_changing_checkout_token(): void
    {
        Mail::fake();
        $this->post(route('cart.store', $this->product()));
        $token = $this->checkoutToken();
        $data = $this->checkoutData($token);
        $data['delivery_method'] = 'delivery';

        $this->post(route('checkout.store'), $data)->assertSessionHasErrors('delivery_address');
        $this->assertDatabaseCount('orders', 0);
        $this->assertSame($token, $this->checkoutToken());

        $data['delivery_address'] = 'Пермь, ул. Пример, 1';
        $this->post(route('checkout.store'), $data)->assertRedirect();
        $this->assertDatabaseCount('orders', 1);
    }

    public function test_database_prevents_duplicate_checkout_tokens(): void
    {
        $token = (string) Str::uuid();
        $order = $this->order('AB-000001', Order::STATUS_NEW);
        $order->update(['checkout_token' => $token]);

        $this->expectException(UniqueConstraintViolationException::class);

        Order::query()->create([
            ...$this->checkoutData($token),
            'total' => 10000,
        ]);
    }

    public function test_order_saves_selected_vehicle_and_displays_snapshot_in_admin(): void
    {
        Mail::fake();
        $vehicle = $this->vehicle();
        $this->withCookie(ResolveVehicleConfiguration::COOKIE_NAME, (string) $vehicle->id)
            ->withCookie(ResolveVehicleConfiguration::YEAR_COOKIE_NAME, '2023');
        $this->post(route('cart.store', $this->product()));
        $this->post(route('checkout.store'), $this->checkoutData($this->checkoutToken()))
            ->assertRedirect();

        $order = Order::query()->sole();
        $this->assertSame([
            'configuration_id' => $vehicle->id,
            'label' => 'Тестовая марка Тестовая модель 2023',
            'make' => 'Тестовая марка',
            'model' => 'Тестовая модель',
            'generation' => 'II поколение',
            'configuration' => 'Универсал с рейлингами',
            'body_style' => 'Универсал',
            'roof_type' => 'Интегрированные рейлинги',
            'year' => 2023,
        ], $order->vehicle_snapshot);

        $vehicle->generation->vehicleModel->make->update(['name' => 'Новое название марки']);
        $vehicle->delete();

        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)->get(route('admin.orders.index'))
            ->assertOk()->assertSee('Тестовая марка Тестовая модель 2023');
        $this->get(route('admin.orders.show', $order))
            ->assertOk()
            ->assertSee('Тестовая марка Тестовая модель 2023')
            ->assertSee('II поколение')
            ->assertSee('Универсал с рейлингами')
            ->assertSee('Интегрированные рейлинги')
            ->assertDontSee('Новое название марки');
    }

    public function test_order_without_selected_vehicle_has_no_snapshot(): void
    {
        Mail::fake();
        $this->post(route('cart.store', $this->product()));
        $this->post(route('checkout.store'), $this->checkoutData($this->checkoutToken()) + [
            'vehicle_snapshot' => ['label' => 'Подставленный автомобиль'],
        ])
            ->assertRedirect();

        $order = Order::query()->sole();
        $this->assertNull($order->vehicle_snapshot);
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)->get(route('admin.orders.index'))->assertOk()->assertSee('Не указан');
        $this->get(route('admin.orders.show', $order))->assertOk()->assertSee('Не указан');
    }

    public function test_checkout_honeypot_rejects_order_without_consuming_token(): void
    {
        Mail::fake();
        $this->post(route('cart.store', $this->product()));
        $token = $this->checkoutToken();

        $this->post(route('checkout.store'), $this->checkoutData($token) + ['website' => 'spam'])
            ->assertSessionHasErrors('website');

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame($token, $this->checkoutToken());
        Mail::assertNothingOutgoing();
    }

    public function test_checkout_with_empty_cart_does_not_create_order(): void
    {
        Mail::fake();
        $product = $this->product();
        $this->post(route('cart.store', $product));
        $token = $this->checkoutToken();
        $this->delete(route('cart.destroy', $product));

        $this->post(route('checkout.store'), $this->checkoutData($token))
            ->assertRedirect(route('cart.index'));

        $this->assertDatabaseCount('orders', 0);
        Mail::assertNothingOutgoing();
    }

    public function test_order_ignores_unavailable_vehicle_and_invalid_year(): void
    {
        Mail::fake();
        $vehicle = $this->vehicle();
        $this->withCookie(ResolveVehicleConfiguration::COOKIE_NAME, (string) $vehicle->id)
            ->withCookie(ResolveVehicleConfiguration::YEAR_COOKIE_NAME, '1900');
        $product = $this->product();
        $this->post(route('cart.store', $product));
        $this->post(route('checkout.store'), $this->checkoutData($this->checkoutToken()))->assertRedirect();

        $order = Order::query()->sole();
        $this->assertNull($order->vehicle_snapshot['year']);
        $this->assertSame('Тестовая марка Тестовая модель 2021–2025', $order->vehicle_snapshot['label']);

        $vehicle->update(['is_active' => false]);
        $this->post(route('cart.store', $product));
        $this->post(route('checkout.store'), $this->checkoutData($this->checkoutToken()))->assertRedirect();
        $this->assertNull(Order::query()->latest('id')->firstOrFail()->vehicle_snapshot);
    }

    public function test_administrator_can_filter_orders_by_status(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $newOrder = $this->order('AB-000001', Order::STATUS_NEW);
        $confirmedOrder = $this->order('AB-000002', Order::STATUS_CONFIRMED);

        $this->actingAs($admin)
            ->get(route('admin.orders.index', ['status' => Order::STATUS_CONFIRMED]))
            ->assertOk()
            ->assertSee($confirmedOrder->number)
            ->assertDontSee($newOrder->number);
    }

    public function test_administrator_sees_order_statistics_on_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->order('AB-000001', Order::STATUS_NEW);
        $this->order('AB-000002', Order::STATUS_NEW);
        $this->order('AB-000003', Order::STATUS_COMPLETED);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Статистика по заказам')
            ->assertSee('Новый')
            ->assertSee('Завершён')
            ->assertSee('На сумму: 20 000 ₽')
            ->assertSee(route('admin.orders.index', ['status' => Order::STATUS_NEW]), false);
    }

    public function test_customer_can_request_a_callback(): void
    {
        Mail::fake();

        $this->from(route('home'))
            ->post(route('callback.store'), ['name' => 'Иван Петров', 'phone' => '+7 900 123-45-67'])
            ->assertRedirect(route('home'));

        $callbackRequest = CallbackRequest::query()->sole();
        $this->assertSame('Иван Петров', $callbackRequest->name);
        $this->assertSame('+7 900 123-45-67', $callbackRequest->phone);
        $this->assertSame(CallbackRequest::STATUS_NEW, $callbackRequest->status);
        Mail::assertSent(CallbackRequested::class, fn (CallbackRequested $mail) => $mail->callbackRequest->is($callbackRequest));
    }

    public function test_administrator_can_process_callback_request(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $callbackRequest = CallbackRequest::query()->create(['name' => 'Иван Петров', 'phone' => '+79001234567']);

        $this->actingAs($admin)
            ->get(route('admin.callback-requests.index'))
            ->assertOk()
            ->assertSee($callbackRequest->name);
        $this->actingAs($admin)
            ->put(route('admin.callback-requests.update', $callbackRequest), ['status' => CallbackRequest::STATUS_IN_PROGRESS, 'expected_status' => CallbackRequest::STATUS_NEW])
            ->assertRedirect(route('admin.callback-requests.show', $callbackRequest));

        $this->assertSame(CallbackRequest::STATUS_IN_PROGRESS, $callbackRequest->fresh()->status);
    }

    public function test_queue_failure_does_not_fail_checkout_or_block_other_notification(): void
    {
        Mail::fake();
        $attempts = 0;
        Bus::shouldReceive('dispatch')->twice()->andReturnUsing(function (SendOrderNotification $job) use (&$attempts) {
            if (++$attempts === 1) {
                throw new RuntimeException('Queue unavailable');
            }

            $job->handle();
        });
        $this->post(route('cart.store', $this->product()));
        $data = $this->checkoutData($this->checkoutToken());

        $this->post(route('checkout.store'), $data)->assertRedirect(route('checkout.success', 1));
        $this->assertDatabaseCount('orders', 1);
        $this->assertEmpty(session('cart.items', []));
        $this->assertDatabaseHas('order_notifications', ['type' => 'order_created', 'queued_at' => null, 'sent_at' => null]);
        Mail::assertSent(OrderConfirmation::class, 1);
        $this->post(route('checkout.store'), $data)->assertRedirect(route('checkout.success', 1));
        $this->assertDatabaseCount('order_notifications', 2);
    }

    public function test_customer_notification_queue_failure_keeps_order_successful(): void
    {
        Mail::fake();
        $attempts = 0;
        Bus::shouldReceive('dispatch')->twice()->andReturnUsing(function (SendOrderNotification $job) use (&$attempts) {
            if (++$attempts === 2) {
                throw new RuntimeException('Queue unavailable');
            }

            $job->handle();
        });
        $this->post(route('cart.store', $this->product()));
        $this->post(route('checkout.store'), $this->checkoutData($this->checkoutToken()))
            ->assertRedirect(route('checkout.success', 1));

        Mail::assertSent(OrderCreated::class, 1);
        $this->assertDatabaseHas('order_notifications', ['type' => 'order_confirmation', 'queued_at' => null, 'sent_at' => null]);
    }

    public function test_pending_notifications_can_be_recovered_without_resending_delivered_mail(): void
    {
        Mail::fake();
        $order = $this->order('AB-000001', Order::STATUS_NEW);
        app(OrderNotifications::class)->recordOrder($order);
        $notification = OrderNotification::query()->firstOrFail();
        (new SendOrderNotification($notification->id))->handle();

        $this->artisan('orders:dispatch-notifications')->assertSuccessful();
        $this->artisan('orders:dispatch-notifications')->assertSuccessful();
        (new SendOrderNotification($notification->id))->handle();

        Mail::assertSent(OrderCreated::class, 1);
        Mail::assertSent(OrderConfirmation::class, 1);
        $this->assertSame(2, OrderNotification::query()->whereNotNull('sent_at')->count());
    }

    public function test_database_queue_stores_separate_jobs_and_recovery_does_not_duplicate_them(): void
    {
        config(['queue.default' => 'database']);
        Mail::fake();
        $this->post(route('cart.store', $this->product()));
        $this->post(route('checkout.store'), $this->checkoutData($this->checkoutToken()))->assertRedirect();

        $this->assertDatabaseCount('jobs', 2);
        $this->assertSame(2, OrderNotification::query()->whereNotNull('queued_at')->whereNull('sent_at')->count());
        $this->artisan('orders:dispatch-notifications')->assertSuccessful();
        $this->assertDatabaseCount('jobs', 2);
        $this->artisan('queue:work', ['connection' => 'database', '--once' => true])->assertSuccessful();
        $this->artisan('queue:work', ['connection' => 'database', '--once' => true])->assertSuccessful();
        $this->assertDatabaseCount('jobs', 0);
        Mail::assertSent(OrderCreated::class, 1);
        Mail::assertSent(OrderConfirmation::class, 1);
    }

    public function test_manager_recipient_list_is_deduplicated_and_sent_separately(): void
    {
        Mail::fake();
        config(['orders.notification_emails' => ' One@example.com, two@example.com,one@example.com, ']);
        $this->post(route('cart.store', $this->product()));
        $this->post(route('checkout.store'), $this->checkoutData($this->checkoutToken()))->assertRedirect();

        Mail::assertSent(OrderCreated::class, 2);
        Mail::assertSent(OrderCreated::class, fn ($mail) => $mail->hasTo('one@example.com') && count($mail->to) === 1);
        Mail::assertSent(OrderCreated::class, fn ($mail) => $mail->hasTo('two@example.com') && count($mail->to) === 1);
        $this->assertDatabaseCount('order_notifications', 3);
    }

    public function test_callback_queue_failure_keeps_request_and_notification(): void
    {
        Bus::shouldReceive('dispatch')->once()->andThrow(new RuntimeException('Queue unavailable'));
        $this->from(route('home'))->post(route('callback.store'), ['name' => 'Иван', 'phone' => '+7 900 123-45-67'])
            ->assertRedirect(route('home'))->assertSessionHas('callback_success');

        $this->assertDatabaseCount('callback_requests', 1);
        $this->assertDatabaseHas('order_notifications', ['type' => 'callback_requested', 'queued_at' => null]);
    }

    public function test_delivery_failure_remains_retryable_and_is_visible_after_final_failure(): void
    {
        $order = $this->order('AB-000001', Order::STATUS_NEW);
        app(OrderNotifications::class)->recordOrder($order);
        $notification = OrderNotification::query()->firstOrFail();
        $notification->update(['queued_at' => now()]);
        $job = new SendOrderNotification($notification->id);
        Mail::shouldReceive('getDefaultDriver')->andReturn('array');
        Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('SMTP unavailable'));

        try {
            $job->handle();
            $this->fail('Delivery exception must reach the worker for retry.');
        } catch (RuntimeException $exception) {
            $this->assertSame('SMTP unavailable', $exception->getMessage());
        }
        $this->assertNull($notification->fresh()->sent_at);
        $job->failed(new RuntimeException('SMTP unavailable'));
        $this->assertNotNull($notification->fresh()->failed_at);
        $this->artisan('orders:notification-status')->assertFailed();

        Mail::fake();
        $job->handle();
        $this->assertNotNull($notification->fresh()->sent_at);
        $this->assertNull($notification->fresh()->failed_at);
        Mail::assertSent(OrderCreated::class, 1);
    }

    public function test_worker_retries_smtp_failures_and_records_exhausted_job(): void
    {
        config(['queue.default' => 'database']);
        $order = $this->order('AB-000001', Order::STATUS_NEW);
        app(OrderNotifications::class)->recordOrder($order);
        app(OrderNotifications::class)->dispatchPending(limit: 1);
        $notification = OrderNotification::query()->firstOrFail();
        Mail::shouldReceive('to')->twice()->andThrow(new RuntimeException('SMTP unavailable'));

        $this->artisan('queue:work', ['connection' => 'database', '--once' => true])->assertSuccessful();
        $queued = DB::table('jobs')->first();
        $this->assertSame(1, $queued->attempts);
        $this->assertGreaterThanOrEqual(now()->timestamp + 59, $queued->available_at);
        $this->assertNull($notification->fresh()->sent_at);
        $this->assertNull($notification->fresh()->failed_at);
        $this->assertDatabaseCount('failed_jobs', 0);

        DB::table('jobs')->update(['attempts' => 4, 'available_at' => now()->timestamp]);
        $this->artisan('queue:work', ['connection' => 'database', '--once' => true])->assertSuccessful();
        $this->assertDatabaseCount('jobs', 0);
        $this->assertDatabaseCount('failed_jobs', 1);
        $this->assertNotNull($notification->fresh()->failed_at);

        Mail::shouldReceive('getDefaultDriver')->andReturn('array');
        Mail::fake();
        $uuid = DB::table('failed_jobs')->value('uuid');
        $this->artisan('queue:retry', ['id' => [$uuid]])->assertSuccessful();
        $this->artisan('queue:work', ['connection' => 'database', '--once' => true])->assertSuccessful();
        $this->assertDatabaseCount('failed_jobs', 0);
        $this->assertNotNull($notification->fresh()->sent_at);
        $this->assertNull($notification->fresh()->failed_at);
        Mail::assertSent(OrderCreated::class, 1);
    }

    public function test_notification_monitoring_detects_old_pending_notifications(): void
    {
        $this->artisan('orders:notification-status')->assertSuccessful();
        $order = $this->order('AB-000001', Order::STATUS_NEW);
        app(OrderNotifications::class)->recordOrder($order);
        $this->travel(16)->minutes();
        $this->artisan('orders:notification-status')->assertFailed();
        $this->artisan('orders:notification-status', ['--max-age' => 30])->assertSuccessful();
    }

    private function order(string $number, string $status): Order
    {
        return Order::query()->create([
            'number' => $number,
            'customer_name' => 'Иван Петров',
            'phone' => '+79001234567',
            'email' => 'ivan@example.com',
            'delivery_method' => 'pickup',
            'status' => $status,
            'total' => 10000,
        ]);
    }

    private function product(): Product
    {
        return Product::query()->create([
            'name' => 'Тестовый автобокс', 'slug' => 'test-autobox', 'price' => 10000, 'stock' => 1, 'is_active' => true,
        ]);
    }

    private function checkoutToken(): string
    {
        return $this->get(route('checkout.create'))->assertOk()->viewData('checkoutToken');
    }

    /** @return array<string, string> */
    private function checkoutData(string $token): array
    {
        return [
            'checkout_token' => $token,
            'customer_name' => 'Иван Петров',
            'phone' => '+7 900 123-45-67',
            'email' => 'ivan@example.com',
            'delivery_method' => 'pickup',
        ];
    }

    private function vehicle(): VehicleConfiguration
    {
        $make = VehicleMake::query()->create(['name' => 'Тестовая марка', 'slug' => 'checkout-make', 'is_active' => true]);
        $model = VehicleModel::query()->create(['vehicle_make_id' => $make->id, 'name' => 'Тестовая модель', 'slug' => 'checkout-model', 'is_active' => true]);
        $generation = VehicleGeneration::query()->create([
            'vehicle_model_id' => $model->id, 'name' => 'II поколение', 'slug' => 'checkout-generation',
            'year_from' => 2021, 'year_to' => 2025, 'is_active' => true,
        ]);
        $body = VehicleBodyStyle::query()->create(['name' => 'Универсал', 'slug' => 'checkout-wagon', 'is_active' => true]);
        $roof = VehicleRoofType::query()->create(['name' => 'Интегрированные рейлинги', 'slug' => 'checkout-rails', 'is_active' => true]);

        return VehicleConfiguration::query()->create([
            'vehicle_generation_id' => $generation->id,
            'vehicle_body_style_id' => $body->id,
            'vehicle_roof_type_id' => $roof->id,
            'slug' => 'checkout-configuration', 'display_name' => 'Универсал с рейлингами', 'is_active' => true,
        ])->load(['generation.vehicleModel.make', 'bodyStyle', 'roofType']);
    }
}

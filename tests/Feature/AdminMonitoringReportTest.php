<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\CallbackRequest;
use App\Models\Fitment;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use App\Models\VehicleConfiguration;
use App\Models\VehicleMake;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMonitoringReportTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        CarbonImmutable::setTestNow();

        parent::tearDown();
    }

    public function test_protected_endpoint_returns_admin_presence_and_changes_for_requested_day(): void
    {
        config(['services.daily_brief.token' => 'test-monitoring-token']);
        CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-09-04 12:00:00', 'Asia/Yekaterinburg'));

        $activeAdmin = User::factory()->create([
            'name' => 'Ирина',
            'is_admin' => true,
            'role' => User::ROLE_CONTENT_MANAGER,
            'last_login_at' => now()->subHours(3),
            'last_seen_at' => now()->subMinutes(18),
        ]);
        $idleAdmin = User::factory()->create([
            'name' => 'Алексей',
            'is_admin' => true,
            'role' => User::ROLE_ADMINISTRATOR,
            'last_seen_at' => now()->subHours(2),
        ]);
        User::factory()->create(['is_admin' => false]);

        $change = AdminActivityLog::query()->create([
            'user_id' => $activeAdmin->id,
            'user_name' => $activeAdmin->name,
            'action' => AdminActivityLog::ACTION_UPDATED,
            'subject_type' => 'auto_box',
            'subject_id' => 42,
            'subject_name' => 'Thule Motion XT',
            'description' => 'Изменил автомобильный бокс «Thule Motion XT»',
        ]);
        $change->forceFill(['created_at' => now()->subHour()])->saveQuietly();

        AdminActivityLog::query()->create([
            'user_id' => $activeAdmin->id,
            'user_name' => $activeAdmin->name,
            'action' => AdminActivityLog::ACTION_LOGIN,
            'description' => 'Вошёл в административную панель',
        ]);

        $response = $this->withToken('test-monitoring-token')->getJson(route(
            'internal.daily-brief.admin-activity',
            ['date' => '2026-09-04', 'limit' => 3],
        ));

        $response->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private')
            ->assertJsonPath('state', 'ok')
            ->assertJsonPath('period.timezone', 'Asia/Yekaterinburg')
            ->assertJsonCount(2, 'administrators')
            ->assertJsonPath('administrators.0.name', 'Ирина')
            ->assertJsonPath('administrators.0.changes_count', 1)
            ->assertJsonPath('administrators.0.changes.0.subject_name', 'Thule Motion XT')
            ->assertJsonPath('administrators.1.name', 'Алексей')
            ->assertJsonPath('administrators.1.changes_count', 0)
            ->assertJsonCount(0, 'administrators.1.changes');

        $this->assertNotNull($idleAdmin);
    }

    public function test_monitoring_endpoint_requires_configured_valid_token(): void
    {
        config(['services.daily_brief.token' => null]);
        $this->getJson(route('internal.daily-brief.admin-activity'))->assertServiceUnavailable();

        config(['services.daily_brief.token' => 'expected-token']);
        $this->getJson(route('internal.daily-brief.admin-activity'))->assertUnauthorized();
        $this->withToken('wrong-token')
            ->getJson(route('internal.daily-brief.admin-activity'))
            ->assertUnauthorized();
    }

    public function test_project_snapshot_returns_operational_aggregates_without_customer_data(): void
    {
        config(['services.daily_brief.token' => 'test-monitoring-token']);
        CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-09-04 12:00:00', 'Asia/Yekaterinburg'));
        VehicleConfiguration::query()->delete();

        $admin = User::factory()->create([
            'name' => 'Ирина',
            'is_admin' => true,
            'last_seen_at' => now()->subMinutes(5),
        ]);

        $this->createOrder(Order::STATUS_NEW, '100.00', now()->subHour());
        $this->createOrder(Order::STATUS_IN_PROGRESS, '200.00', now()->subDay());
        $this->createOrder(Order::STATUS_COMPLETED, '300.00', now()->subHours(2));

        CallbackRequest::query()->create(['name' => 'Клиент 1', 'phone' => '+70000000001', 'status' => CallbackRequest::STATUS_NEW]);
        CallbackRequest::query()->create(['name' => 'Клиент 2', 'phone' => '+70000000002', 'status' => CallbackRequest::STATUS_IN_PROGRESS]);
        CallbackRequest::query()->create(['name' => 'Клиент 3', 'phone' => '+70000000003', 'status' => CallbackRequest::STATUS_COMPLETED]);

        $roofRackTypeId = ProductType::query()->where('code', 'roof_rack')->value('id');
        $roofRackWithoutFitment = Product::query()->create([
            'product_type_id' => $roofRackTypeId,
            'name' => 'Багажник без применяемости',
            'slug' => 'rack-without-fitment',
            'price' => 10000,
            'stock' => 1,
            'is_active' => true,
        ]);
        $roofRackWithoutFitment->roofRack()->create([]);

        $roofRackWithFitment = Product::query()->create([
            'product_type_id' => $roofRackTypeId,
            'name' => 'Багажник с применяемостью',
            'slug' => 'rack-with-fitment',
            'price' => 12000,
            'stock' => 1,
            'is_active' => true,
        ]);
        $roofRackWithFitment->roofRack()->create([]);
        $roofRackWithFitment->images()->create(['path' => 'products/rack.jpg']);

        Product::query()->create([
            'name' => 'Скрытый товар',
            'slug' => 'hidden-product',
            'price' => 5000,
            'stock' => 0,
            'is_active' => false,
        ]);

        $make = VehicleMake::query()->create(['name' => 'Test', 'slug' => 'test', 'is_active' => true]);
        $model = $make->models()->create(['name' => 'Model', 'slug' => 'model', 'is_active' => true]);
        $generation = $model->generations()->create(['name' => 'Generation', 'slug' => 'generation', 'is_active' => true]);
        $configurationWithFitment = $generation->configurations()->create([
            'display_name' => 'С совместимостью',
            'is_active' => true,
        ]);
        $generation->configurations()->create([
            'display_name' => 'Без совместимости',
            'is_active' => true,
        ]);

        $fitment = Fitment::query()->create(['code' => 'TEST', 'name' => 'Тест', 'is_active' => true]);
        $fitment->products()->attach($roofRackWithFitment, ['status' => 'active']);
        $fitment->configurations()->attach($configurationWithFitment);

        AdminActivityLog::query()->create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => AdminActivityLog::ACTION_UPDATED,
            'subject_type' => 'roof_rack',
            'subject_id' => $roofRackWithFitment->id,
            'subject_name' => $roofRackWithFitment->name,
            'description' => 'Небезопасный текст buyer@example.test +70000000000',
        ]);
        AdminActivityLog::query()->create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => AdminActivityLog::ACTION_UPDATED,
            'subject_type' => 'order',
            'subject_id' => 1,
            'subject_name' => 'Заказ клиента',
            'description' => 'Комментарий покупателя',
        ]);

        $response = $this->withToken('test-monitoring-token')->getJson(route(
            'internal.monitoring.project-snapshot',
            ['date' => '2026-09-04', 'limit' => 3],
        ));

        $response->assertOk()
            ->assertJsonPath('orders.by_status.new.count', 1)
            ->assertJsonPath('orders.by_status.new.amount', '100.00')
            ->assertJsonPath('orders.by_status.in_progress.count', 1)
            ->assertJsonPath('orders.by_status.cancelled.amount', '0.00')
            ->assertJsonPath('orders.created_for_day.count', 2)
            ->assertJsonPath('orders.created_for_day.amount', '400.00')
            ->assertJsonPath('orders.awaiting_processing', 1)
            ->assertJsonPath('callback_requests.new', 1)
            ->assertJsonPath('callback_requests.unclosed', 2)
            ->assertJsonPath('products.total', 3)
            ->assertJsonPath('products.published', 2)
            ->assertJsonPath('products.hidden', 1)
            ->assertJsonPath('products.without_images', 2)
            ->assertJsonPath('products.published_roof_racks_without_fitments', 1)
            ->assertJsonPath('vehicle_configurations.without_compatibility', 1)
            ->assertJsonPath('activity.changes_for_day', 1)
            ->assertJsonCount(1, 'activity.recent_changes')
            ->assertJsonPath('activity.recent_changes.0.description', 'Изменён: Автобагажник «Багажник с применяемостью»')
            ->assertJsonMissing(['customer_name' => 'Иван Иванов'])
            ->assertJsonMissing(['phone' => '+70000000000'])
            ->assertJsonMissing(['description' => 'Комментарий покупателя']);

        $this->assertStringNotContainsString('buyer@example.test', $response->getContent());
        $this->assertStringNotContainsString('+70000000000', $response->getContent());
        $this->assertStringNotContainsString('Комментарий покупателя', $response->getContent());
    }

    public function test_artisan_command_outputs_same_report_without_http_credentials(): void
    {
        User::factory()->create(['name' => 'Администратор', 'is_admin' => true]);

        $this->artisan('monitoring:admin-summary', ['--date' => now()->toDateString(), '--limit' => 1])
            ->expectsOutputToContain('"administrators"')
            ->assertSuccessful();
    }

    private function createOrder(string $status, string $total, CarbonInterface $createdAt): Order
    {
        $order = Order::query()->create([
            'customer_name' => 'Иван Иванов',
            'phone' => '+70000000000',
            'email' => 'buyer@example.test',
            'delivery_method' => 'pickup',
            'delivery_address' => 'Адрес покупателя',
            'comment' => 'Комментарий покупателя',
            'status' => $status,
            'total' => $total,
        ]);
        $order->forceFill(['created_at' => $createdAt])->saveQuietly();

        return $order;
    }
}

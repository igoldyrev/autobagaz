<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderReservation;
use App\Models\Product;
use App\Models\StockFileImport;
use App\Models\User;
use App\Services\MonitoringHeartbeats;
use App\Services\OrderPayments;
use App\Services\OrderReservations;
use App\Services\OrderTerms;
use App\Services\StockFileService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class OrderReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_last_unit_can_only_be_reserved_once_and_retries_do_not_extend_the_deadline(): void
    {
        $this->freezeTime();
        $product = $this->product(1);
        $first = $this->order($product);
        $deadline = $first->reservation_expires_at->toIso8601String();
        $second = $this->order($product);
        $this->assertSame(1, $first->reservations()->sole()->quantity);
        $this->assertSame(0, $second->reservations()->count());
        $this->assertSame(0, $product->fresh()->available_stock);
        $this->assertSame(1, $product->fresh()->stock);
        $this->travel(5)->minutes();
        DB::transaction(fn () => app(OrderReservations::class)->create($first->fresh()));
        DB::transaction(fn () => app(OrderReservations::class)->allocate($first->fresh()));
        $this->assertSame($deadline, $first->fresh()->reservation_expires_at->toIso8601String());
        $this->assertSame(1, OrderReservation::query()->count());
    }

    public function test_partial_and_zero_stock_do_not_create_fictitious_reservations(): void
    {
        $product = $this->product(2);
        $order = $this->order($product, 5);
        $this->assertSame(2, $order->reservations()->sole()->quantity);
        $empty = $this->order($this->product(0));
        $this->assertSame(0, $empty->reservations()->count());
        $this->assertSame('Под заказ — без складского резерва', $empty->fresh()->reservationLabel());
        $page = $this->get($order->customerUrl())->assertOk()->assertSee('Остальные 3 шт.')->assertSee('15')->assertDontSee('Продление недоступно')->assertDontSee('<h2>Оплата и резерв</h2>', false)
            ->assertDontSee('Исходная заявка')->assertSeeInOrder(['order-processing-steps', 'order-reservation'], false);
        $this->assertSame(1, substr_count($page->getContent(), '<table'));
    }

    public function test_expired_reservations_stop_affecting_availability_before_cleanup_and_are_never_extended(): void
    {
        $this->freezeTime();
        $product = $this->product(1);
        $order = $this->order($product);
        $this->travel(899)->seconds();
        $this->assertSame(0, $product->fresh()->available_stock);
        $this->travel(1)->seconds();
        $this->assertSame(1, $product->fresh()->available_stock);
        $this->assertSame(1, Product::query()->whereAvailable(true)->count());
        $this->assertSame('active', $order->reservations()->sole()->state);
        $this->artisan('orders:expire-reservations')->assertSuccessful();
        $this->assertSame('expired', $order->reservations()->sole()->state);
        $this->assertSame('ok', app(MonitoringHeartbeats::class)->snapshot()['tasks']['expire_reservations']['state']);
        $this->travel(180)->seconds();
        $this->assertSame('stale', app(MonitoringHeartbeats::class)->snapshot()['tasks']['expire_reservations']['state']);
        $this->assertSame(0, app(OrderReservations::class)->expireDue());
        DB::transaction(fn () => app(OrderReservations::class)->allocate($order->fresh()));
        $this->assertSame('expired', $order->reservations()->sole()->state);
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_payment_is_idempotent_and_keeps_the_reservation_until_pickup_without_manager_confirmation(): void
    {
        $this->freezeTime();
        $product = $this->product(2);
        $order = $this->order($product);
        $this->pay($order);
        $this->pay($order);
        $this->travel(2)->days();
        $this->artisan('orders:expire-reservations')->assertSuccessful();
        $this->assertSame('paid', $order->reservations()->sole()->state);
        $this->assertNull($order->reservations()->sole()->expires_at);
        $this->assertSame(1, $product->fresh()->available_stock);
        $this->assertDatabaseCount('order_payment_events', 1);
        $this->assertTrue($order->fresh()->canCollect());
        $this->get($order->customerUrl())->assertOk()->assertSee('Оплачен')->assertSee('Можно приезжать');
        $manager = User::factory()->create(['is_admin' => true]);
        $this->actingAs($manager)->get(route('admin.orders.index'))->assertOk()->assertSee('Оплачен')->assertSee('резерв сохранён');
        $this->get(route('admin.orders.show', $order))->assertOk()->assertSee('Состояние оплаты и резерва');
        $this->transition($order, $manager, 'completed')->assertSessionDoesntHaveErrors();
        $this->assertSame(1, $product->fresh()->stock);
        $this->assertSame(1, $product->fresh()->available_stock);
        $this->assertSame('consumed', $order->reservations()->sole()->state);
        $this->transition($order, $manager, 'completed')->assertSessionHasErrors();
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_late_payment_does_not_steal_a_new_reservation(): void
    {
        $this->freezeTime();
        $product = $this->product(1);
        $old = $this->order($product);
        $this->travel(15)->minutes();
        $new = $this->order($product);
        $this->pay($old);
        $this->assertSame('paid', $old->fresh()->payment_status);
        $this->assertSame('expired', $old->reservations()->sole()->state);
        $this->assertFalse($old->fresh()->canCollect());
        $this->assertSame('active', $new->reservations()->sole()->state);
        $this->assertSame(0, $product->fresh()->available_stock);
        $this->get($old->customerUrl())->assertSee('Перед получением свяжитесь с менеджером');
    }

    public function test_cancellation_releases_stock_without_debit_or_automatic_refund(): void
    {
        $product = $this->product(1);
        $order = $this->order($product);
        $this->pay($order);
        $manager = User::factory()->create(['is_admin' => true]);
        $this->transition($order, $manager, 'cancelled', ['cancellation_reason' => 'Покупатель отказался'])->assertSessionDoesntHaveErrors();
        $this->assertSame('released', $order->reservations()->sole()->state);
        $this->assertSame(1, $product->fresh()->available_stock);
        $this->assertSame(1, $product->fresh()->stock);
        $this->assertSame('paid', $order->fresh()->payment_status);
    }

    public function test_shipping_and_completion_debit_once_and_return_requires_actual_receipt(): void
    {
        $product = $this->product(3);
        $order = $this->order($product, 2, 'delivery');
        $this->pay($order);
        $manager = User::factory()->create(['is_admin' => true]);
        foreach (['in_progress', 'confirmed', 'ready', 'shipped', 'completed'] as $status) {
            $this->transition($order, $manager, $status)->assertSessionDoesntHaveErrors();
        }
        $this->assertSame(1, $product->fresh()->stock);
        app(OrderPayments::class)->refund($order, 'yookassa', 'refund-1', '200.00');
        $this->assertSame(1, $product->fresh()->stock);
        $data = ['product_id' => $product->id, 'quantity' => 1, 'reason' => 'Возврат покупателя', 'expected_returned' => 0];
        $this->post(route('admin.orders.returns', $order), $data)->assertSessionHasErrors('received');
        $this->post(route('admin.orders.returns', $order), $data + ['received' => '1'])->assertSessionDoesntHaveErrors();
        $this->assertSame(2, $product->fresh()->stock);
        $this->post(route('admin.orders.returns', $order), $data + ['received' => '1'])->assertSessionHasErrors('reservation');
        $this->assertSame(2, $product->fresh()->stock);
        $this->post(route('admin.orders.returns', $order), array_replace($data, ['expected_returned' => 1, 'received' => '1']))->assertSessionDoesntHaveErrors();
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertSame('returned', $order->reservations()->sole()->state);
    }

    public function test_confirmed_full_refund_releases_unissued_goods_and_duplicate_refund_is_safe(): void
    {
        $product = $this->product(1);
        $order = $this->order($product);
        $this->pay($order);
        app(OrderPayments::class)->refund($order, 'yookassa', 'refund-1', '100.00');
        app(OrderPayments::class)->refund($order, 'yookassa', 'refund-1', '100.00');
        $this->assertSame('refunded', $order->fresh()->payment_status);
        $this->assertSame(1, $product->fresh()->available_stock);
        $this->assertSame(1, $product->fresh()->stock);
        $this->assertFalse($order->fresh()->canCollect());
    }

    public function test_paid_supply_can_be_reserved_after_arrival_without_extending_unpaid_reservations(): void
    {
        $this->freezeTime();
        $product = $this->product(0);
        $order = $this->order($product);
        $this->pay($order);
        $this->travel(1)->days();
        $product->update(['stock' => 2]);
        $manager = User::factory()->create(['is_admin' => true]);
        $this->actingAs($manager)->post(route('admin.orders.reserve', $order))->assertSessionDoesntHaveErrors();
        $this->post(route('admin.orders.reserve', $order))->assertSessionDoesntHaveErrors();
        $this->assertSame(1, $order->reservations()->count());
        $this->assertTrue($order->fresh()->canCollect());
        $unpaid = $this->order($product);
        $this->post(route('admin.orders.reserve', $unpaid))->assertSessionHasErrors('reservation');
    }

    public function test_import_and_product_editor_cannot_reduce_physical_stock_below_live_reservations(): void
    {
        $product = $this->product(3);
        $order = $this->order($product, 2);
        $manager = User::factory()->create(['is_admin' => true]);
        $service = app(StockFileService::class);
        $export = $service->export($manager);
        $import = $service->preview($manager, 'stock.xlsx', ['export_id' => $export->id, 'rows' => [['id' => $product->id, 'stock' => 1, 'price' => 200, 'location' => 'Тест']]]);
        try {
            $service->apply($import, $manager, []);
            $this->fail('Import must reject stock below the reserved amount.');
        } catch (ValidationException $error) {
            $this->assertArrayHasKey('stock', $error->errors());
        }
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertSame('100.00', $product->fresh()->price);
        $this->assertNull(StockFileImport::query()->findOrFail($import->id)->applied_at);
        try {
            $product->update(['stock' => 1]);
            $this->fail('Editor must reject stock below the reserved amount.');
        } catch (ValidationException) {
            $this->assertSame(3, $product->fresh()->stock);
        }
        $this->assertSame(1, Product::query()->withAvailability()->sole()->available_stock);
        $this->assertSame(2, $order->reservations()->sole()->quantity);
    }

    public function test_payment_amount_currency_and_references_are_checked(): void
    {
        $order = $this->order($this->product(2));
        foreach ([['99.00', 'RUB'], ['100.00', 'USD']] as [$amount, $currency]) {
            try {
                app(OrderPayments::class)->confirm($order, 'sberbank', 'bad', $amount, $currency);
                $this->fail('Invalid payment must not be accepted.');
            } catch (ValidationException) {
                $this->assertSame('unpaid', $order->fresh()->payment_status);
            }
        }
        $this->pay($order);
        $other = $this->order($order->items->first()->product);
        $this->expectException(ValidationException::class);
        app(OrderPayments::class)->confirm($other, 'yookassa', 'payment-'.$order->id, '100.00');
    }

    public function test_accepted_terms_reconcile_quantity_without_extending_deadline(): void
    {
        $this->freezeTime();
        $product = $this->product(5);
        $order = $this->order($product, 2);
        $manager = User::factory()->create(['is_admin' => true]);
        $deadline = $order->reservation_expires_at->toIso8601String();
        $this->travel(5)->minutes();
        $item = $order->items->sole();
        $data = [
            'expected_status' => 'new', 'expected_version' => 0,
            'items' => [$item->id => ['quantity' => 3, 'supply_terms' => 'В наличии']],
            'delivery_method' => 'pickup', 'delivery_address' => null, 'delivery_cost' => '0', 'delivery_terms' => 'Самовывоз',
            'payment_method' => 'card', 'payment_terms' => 'Предоплата', 'change_reason' => 'Количество',
        ];
        $terms = app(OrderTerms::class)->propose($order, $manager, $data);
        $this->assertSame(2, $order->reservations()->sole()->quantity);
        app(OrderTerms::class)->accept($order, $terms->version);
        $this->assertSame(3, $order->reservations()->sole()->quantity);
        $this->assertSame($deadline, $order->fresh()->reservation_expires_at->toIso8601String());
        $this->assertSame(2, $product->fresh()->available_stock);
    }

    private function product(int $stock): Product
    {
        return Product::query()->create(['name' => 'Товар', 'slug' => (string) Str::uuid(), 'price' => '100.00', 'stock' => $stock, 'is_active' => true]);
    }

    public function test_paid_order_can_agree_supply_terms_but_composition_changes_require_payment_reconciliation(): void
    {
        $product = $this->product(5);
        $order = $this->order($product, 2);
        $this->pay($order);
        $manager = User::factory()->create(['is_admin' => true]);
        $item = $order->items->sole();
        $data = [
            'expected_status' => 'new', 'expected_version' => 0,
            'items' => [$item->id => ['quantity' => 2, 'supply_terms' => 'Можно забрать сегодня']],
            'delivery_method' => 'pickup', 'delivery_address' => null, 'delivery_cost' => '0', 'delivery_terms' => 'Самовывоз',
            'payment_method' => 'card', 'payment_terms' => 'Оплачено', 'change_reason' => 'Получение',
        ];
        $terms = app(OrderTerms::class)->propose($order, $manager, $data);
        app(OrderTerms::class)->accept($order, $terms->version);
        $this->assertTrue($order->fresh()->canCollect());
        $this->assertSame(2, $order->reservations()->sole()->quantity);
        $this->assertNull($order->reservations()->sole()->expires_at);
        $data['expected_version'] = 1;
        $data['items'][$item->id]['quantity'] = 3;
        try {
            app(OrderTerms::class)->propose($order, $manager, $data);
            $this->fail('Paid composition changes must not bypass payment reconciliation.');
        } catch (ValidationException $error) {
            $this->assertArrayHasKey('items', $error->errors());
        }
        $this->assertSame(1, $order->termsVersions()->count());
    }

    private function order(Product $product, int $quantity = 1, string $delivery = 'pickup'): Order
    {
        return DB::transaction(function () use ($product, $quantity, $delivery) {
            $order = Order::query()->create(['customer_name' => 'Покупатель', 'phone' => '+79000000000', 'email' => 'buyer@example.test', 'delivery_method' => $delivery, 'total' => $quantity * 100]);
            $order->update(['number' => 'TEST-'.$order->id]);
            $order->items()->create(['product_id' => $product->id, 'product_name' => $product->name, 'unit_price' => '100.00', 'quantity' => $quantity, 'total' => $quantity * 100]);
            app(OrderReservations::class)->create($order);

            return $order->fresh();
        });
    }

    private function pay(Order $order): void
    {
        app(OrderPayments::class)->confirm($order, 'yookassa', 'payment-'.$order->id, $order->total);
    }

    private function transition(Order $order, User $manager, string $status, array $extra = []): TestResponse
    {
        return $this->actingAs($manager)->put(route('admin.orders.update', $order), [
            'status' => $status, 'expected_status' => $order->fresh()->status, 'expected_terms_version' => 0, 'fulfillment_confirmed' => '1', ...$extra,
        ]);
    }
}

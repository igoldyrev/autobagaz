<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderPayments;
use App\Services\OrderReservations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class PartialOrderFulfillmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_partial_pickup_keeps_remaining_stock_reserved_and_last_batch_completes_order(): void
    {
        [$order, $product, $manager] = $this->paidOrder(5, 5);
        $this->fulfill($order, $manager, [$product->id => 2])->assertSessionDoesntHaveErrors();
        $this->assertSame('in_progress', $order->fresh()->status);
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertSame(0, $product->fresh()->available_stock);
        $row = $order->reservations()->sole();
        $this->assertSame([3, 2, 'paid'], [$row->quantity, $row->fulfilled_quantity, $row->state]);
        $this->assertNull($row->expires_at);
        $this->get($order->customerUrl())->assertOk()->assertSee('Выдано / отправлено: 2 шт.')->assertSee('Осталось передать: 3 шт.');
        $this->get(route('admin.orders.show', $order))->assertOk()->assertSee('Выдать часть заказа')->assertSee('Принять возврат:');
        $this->fulfill($order, $manager, [$product->id => 3])->assertSessionDoesntHaveErrors();
        $this->assertSame('completed', $order->fresh()->status);
        $this->assertSame(0, $product->fresh()->stock);
        $this->assertSame([0, 5, 'consumed'], array_values($row->fresh()->only(['quantity', 'fulfilled_quantity', 'state'])));
        $this->assertSame(2, $order->fresh()->fulfillment_version);
        $this->assertTrue(AdminActivityLog::where('subject_id', $order->id)->where('user_id', $manager->id)->where('description', 'like', 'Передача части №2:%')->exists());
        $this->fulfill($order, $manager, [$product->id => 1])->assertSessionHasErrors('reservation');
    }

    public function test_separate_shipments_leave_order_open_until_last_shipment_and_completion_does_not_debit_again(): void
    {
        [$order, $product, $manager] = $this->paidOrder(4, 3, 'delivery');
        $this->fulfill($order, $manager, [$product->id => 1])->assertSessionDoesntHaveErrors();
        $this->assertSame('in_progress', $order->fresh()->status);
        $this->assertDatabaseMissing('order_notifications', ['order_id' => $order->id, 'type' => 'order_shipped']);
        $this->fulfill($order, $manager, [$product->id => 2])->assertSessionDoesntHaveErrors();
        $this->assertSame('shipped', $order->fresh()->status);
        $this->assertDatabaseHas('order_notifications', ['order_id' => $order->id, 'type' => 'order_shipped']);
        $this->assertSame(1, $product->fresh()->stock);
        $this->actingAs($manager)->put(route('admin.orders.update', $order), [
            'status' => 'completed', 'expected_status' => 'shipped', 'expected_terms_version' => 0,
            'expected_fulfillment_version' => 2, 'fulfillment_confirmed' => '1',
        ])->assertSessionDoesntHaveErrors();
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_arrival_only_reserves_unissued_quantity_even_after_return(): void
    {
        [$order, $product, $manager] = $this->paidOrder(2, 5);
        $this->fulfill($order, $manager, [$product->id => 2])->assertSessionDoesntHaveErrors();
        $this->assertFalse($order->fresh()->canCollect());
        $this->receiveReturn($order, $manager, $product, 1)->assertSessionDoesntHaveErrors();
        $product->update(['stock' => 5]);
        app(OrderReservations::class)->reserveArrived($order, $manager);
        app(OrderReservations::class)->reserveArrived($order, $manager);
        $row = $order->reservations()->sole();
        $this->assertSame([3, 2, 1, 'paid'], array_values($row->only(['quantity', 'fulfilled_quantity', 'returned_quantity', 'state'])));
        $this->assertSame(2, $product->fresh()->available_stock);
        $this->assertTrue($order->fresh()->canCollect());
        $this->fulfill($order, $manager, [$product->id => 3])->assertSessionDoesntHaveErrors();
        $this->assertSame(2, $product->fresh()->stock);
        $this->assertSame(5, $row->fresh()->fulfilled_quantity);
    }

    public function test_whole_order_action_after_partial_pickup_only_consumes_remainder(): void
    {
        [$order, $product, $manager] = $this->paidOrder(5, 5);
        $this->fulfill($order, $manager, [$product->id => 2])->assertSessionDoesntHaveErrors();
        $payload = ['status' => 'completed', 'expected_status' => 'in_progress', 'expected_terms_version' => 0, 'fulfillment_confirmed' => '1'];
        $this->actingAs($manager)->put(route('admin.orders.update', $order), $payload)->assertSessionHasErrors('reservation');
        $this->assertSame(3, $product->fresh()->stock);
        $this->put(route('admin.orders.update', $order), $payload + ['expected_fulfillment_version' => 1])->assertSessionDoesntHaveErrors();
        $this->assertSame(0, $product->fresh()->stock);
        $this->assertSame(5, $order->reservations()->sole()->fulfilled_quantity);
    }

    public function test_cancel_after_partial_issue_releases_only_unissued_stock_and_return_is_still_available(): void
    {
        [$order, $product, $manager] = $this->paidOrder(5, 5);
        $this->fulfill($order, $manager, [$product->id => 2])->assertSessionDoesntHaveErrors();
        $this->actingAs($manager)->put(route('admin.orders.update', $order), [
            'status' => 'cancelled', 'expected_status' => 'in_progress', 'cancellation_reason' => 'Отказ от остатка',
        ])->assertSessionDoesntHaveErrors();
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertSame(3, $product->fresh()->available_stock);
        $this->receiveReturn($order, $manager, $product, 3)->assertSessionHasErrors('reservation');
        $this->receiveReturn($order, $manager, $product, 2)->assertSessionDoesntHaveErrors();
        $this->assertSame(5, $product->fresh()->stock);
        $this->assertSame('released', $order->reservations()->sole()->state);
    }

    public function test_return_during_partial_issue_preserves_remaining_reserve_and_replay_is_rejected(): void
    {
        [$order, $product, $manager] = $this->paidOrder(5, 5);
        $this->fulfill($order, $manager, [$product->id => 2])->assertSessionDoesntHaveErrors();
        $this->receiveReturn($order, $manager, $product, 2)->assertSessionDoesntHaveErrors();
        $this->assertSame(5, $product->fresh()->stock);
        $this->assertSame(2, $product->fresh()->available_stock);
        $this->assertSame('paid', $order->reservations()->sole()->state);
        $this->receiveReturn($order, $manager, $product, 2)->assertSessionHasErrors('reservation');
        app(OrderReservations::class)->reserveArrived($order, $manager);
        $this->assertSame(3, $order->reservations()->sole()->quantity);
    }

    public function test_full_refund_after_partial_issue_releases_remainder_without_undoing_issue(): void
    {
        [$order, $product, $manager] = $this->paidOrder(5, 5);
        $this->fulfill($order, $manager, [$product->id => 2])->assertSessionDoesntHaveErrors();
        app(OrderPayments::class)->refund($order, 'yookassa', 'refund', '500.00');
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertSame(3, $product->fresh()->available_stock);
        $this->assertSame(2, $order->reservations()->sole()->fulfilled_quantity);
        $this->fulfill($order, $manager, [$product->id => 1])->assertSessionHasErrors('reservation');
        $this->receiveReturn($order, $manager, $product, 2)->assertSessionDoesntHaveErrors();
        $this->assertSame(5, $product->fresh()->stock);
    }

    public function test_stale_form_cannot_issue_another_batch_even_when_status_is_unchanged(): void
    {
        [$order, $product, $manager] = $this->paidOrder(5, 5);
        $order->update(['status' => 'in_progress']);
        $payload = $this->payload($order, [$product->id => 1]);
        $this->actingAs($manager)->post(route('admin.orders.fulfill', $order), $payload)->assertSessionDoesntHaveErrors();
        $this->post(route('admin.orders.fulfill', $order), $payload)->assertSessionHasErrors('reservation');
        $this->assertSame(4, $product->fresh()->stock);
        $this->assertSame(1, $order->reservations()->sole()->fulfilled_quantity);
    }

    public function test_invalid_batch_rolls_back_all_products_and_stock_changes(): void
    {
        [$order, $product, $manager] = $this->paidOrder(5, 5);
        $this->fulfill($order, $manager, [$product->id => 1, 999999 => 1])->assertSessionHasErrors('reservation');
        $this->assertSame(5, $product->fresh()->stock);
        $this->assertSame(5, $order->reservations()->sole()->quantity);
        $this->assertSame(0, $order->fresh()->fulfillment_version);
        $this->fulfill($order, $manager, [$product->id => 6])->assertSessionHasErrors('reservation');
        $this->fulfill($order, $manager, [$product->id => 0])->assertSessionHasErrors('reservation');
        $this->fulfill($order, $manager, [$product->id => -1])->assertSessionHasErrors('quantities.'.$product->id);
        $this->assertSame(5, $product->fresh()->stock);
    }

    public function test_unpaid_unaccepted_stale_terms_and_unconfirmed_transfers_are_rejected(): void
    {
        [$order, $product, $manager] = $this->paidOrder(5, 5);
        $payload = $this->payload($order, [$product->id => 1]);
        unset($payload['fulfilled']);
        $this->actingAs($manager)->post(route('admin.orders.fulfill', $order), $payload)->assertSessionHasErrors('fulfilled');
        $this->fulfill($order, $manager, [$product->id => 1], ['expected_terms_version' => 1])->assertSessionHasErrors('reservation');
        $order->termsVersions()->create(['created_by_name' => $manager->name, 'version' => 1, 'items' => [], 'goods_total' => 500, 'delivery_method' => 'pickup', 'delivery_terms' => 'Самовывоз', 'payment_method' => 'card', 'payment_terms' => 'Оплачено', 'change_reason' => 'Сроки']);
        $this->fulfill($order, $manager, [$product->id => 1])->assertSessionHasErrors('reservation');
        $order->termsVersions()->delete();
        $order->refresh()->forceFill(['payment_status' => 'unpaid'])->save();
        $this->fulfill($order, $manager, [$product->id => 1])->assertSessionHasErrors('reservation');
        $this->assertSame(5, $product->fresh()->stock);
    }

    public function test_transfer_requires_orders_permission(): void
    {
        [$order, $product] = $this->paidOrder(5, 5);
        $this->actingAs(User::factory()->create())->post(route('admin.orders.fulfill', $order), $this->payload($order, [$product->id => 1]))->assertForbidden();
        $this->assertSame(5, $product->fresh()->stock);
    }

    public function test_migration_backfills_issued_quantities_without_changing_stock_or_live_reserves(): void
    {
        [$order, $product] = $this->paidOrder(5, 5);
        $row = $order->reservations()->sole();
        $row->update(['quantity' => 5, 'state' => 'consumed']);
        [$liveOrder, $liveProduct] = $this->paidOrder(3, 2);
        $migration = require database_path('migrations/2026_11_02_010000_add_partial_order_fulfillment.php');
        $migration->down();
        $migration->up();
        $this->assertSame(5, $row->fresh()->fulfilled_quantity);
        $this->assertSame(5, $product->fresh()->stock);
        $this->assertSame(5, $product->fresh()->available_stock);
        $this->assertSame(0, $liveOrder->reservations()->sole()->fulfilled_quantity);
        $this->assertSame(2, $liveOrder->reservations()->sole()->quantity);
        $this->assertSame(1, $liveProduct->fresh()->available_stock);
    }

    public function test_selected_positions_and_quantities_can_be_issued_in_several_batches(): void
    {
        $second = Product::create(['name' => 'Второй товар', 'slug' => 'second-product', 'price' => 100, 'stock' => 4, 'is_active' => true]);
        [$order, $first, $manager] = $this->paidOrder(3, 3, additional: $second);
        $this->fulfill($order, $manager, [$first->id => 1, $second->id => 0])->assertSessionDoesntHaveErrors();
        $this->assertSame(2, $first->fresh()->stock);
        $this->assertSame(4, $second->fresh()->stock);
        $this->assertSame(2, $order->reservations()->where('product_id', $second->id)->sole()->quantity);
        $this->fulfill($order, $manager, [$first->id => 2, $second->id => 1])->assertSessionDoesntHaveErrors();
        $this->assertSame('in_progress', $order->fresh()->status);
        $this->fulfill($order, $manager, [$second->id => 1])->assertSessionDoesntHaveErrors();
        $this->assertSame('completed', $order->fresh()->status);
        $this->assertSame(0, $first->fresh()->stock);
        $this->assertSame(2, $second->fresh()->stock);
        $this->assertSame(5, $order->reservations()->sum('fulfilled_quantity'));
    }

    private function paidOrder(int $stock, int $quantity, string $delivery = 'pickup', ?Product $additional = null): array
    {
        $product = Product::create(['name' => 'Товар', 'slug' => (string) Str::uuid(), 'price' => 100, 'stock' => $stock, 'is_active' => true]);
        $order = Order::create(['number' => 'PARTIAL-'.Str::uuid(), 'customer_name' => 'Покупатель', 'phone' => '+79000000000', 'email' => 'buyer@example.test', 'delivery_method' => $delivery, 'total' => $quantity * 100 + ($additional ? 200 : 0)]);
        $order->items()->create(['product_id' => $product->id, 'product_name' => $product->name, 'unit_price' => 100, 'quantity' => $quantity, 'total' => $quantity * 100]);
        if ($additional) {
            $order->items()->create(['product_id' => $additional->id, 'product_name' => $additional->name, 'unit_price' => 100, 'quantity' => 2, 'total' => 200]);
        }
        app(OrderReservations::class)->create($order);
        app(OrderPayments::class)->confirm($order, 'yookassa', 'payment-'.$order->id, $order->total);

        return [$order, $product, User::factory()->create(['is_admin' => true])];
    }

    private function payload(Order $order, array $quantities): array
    {
        $order = $order->fresh();

        return ['expected_status' => $order->status, 'expected_terms_version' => $order->latestTermsVersion?->version ?? 0,
            'expected_fulfillment_version' => $order->fulfillment_version, 'quantities' => $quantities, 'fulfilled' => '1'];
    }

    private function fulfill(Order $order, User $manager, array $quantities, array $overrides = []): TestResponse
    {
        return $this->actingAs($manager)->post(route('admin.orders.fulfill', $order), array_replace($this->payload($order, $quantities), $overrides));
    }

    private function receiveReturn(Order $order, User $manager, Product $product, int $quantity): TestResponse
    {
        return $this->actingAs($manager)->post(route('admin.orders.returns', $order), [
            'product_id' => $product->id, 'quantity' => $quantity, 'reason' => 'Возврат покупателя', 'expected_returned' => 0, 'received' => '1',
        ]);
    }
}

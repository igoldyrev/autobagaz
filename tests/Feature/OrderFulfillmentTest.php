<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderTerms;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class OrderFulfillmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_pickup_can_skip_supply_and_only_completes_after_explicit_receipt_or_installation_confirmation(): void
    {
        [$order, $manager] = $this->order();
        foreach (['in_progress', 'confirmed', 'ready'] as $status) {
            $this->transition($order, $manager, $status)->assertSessionDoesntHaveErrors();
        }
        $this->get($order->customerUrl())->assertOk()->assertSee('Готов к выдаче')
            ->assertSee('Если согласована установка')->assertDontSee('Отправлен');
        $this->transition($order, $manager, 'completed')->assertSessionHasErrors('fulfillment_confirmed');
        $this->assertSame('ready', $order->fresh()->status);
        $this->transition($order, $manager, 'completed', ['fulfillment_confirmed' => '1'])->assertSessionDoesntHaveErrors();
        $this->get($order->customerUrl())->assertSee('Завершён')->assertSee('установка в магазине завершена');
        $this->assertTrue(AdminActivityLog::query()->where('description', 'like', '%Менеджер подтвердил получение всего заказа%')->exists());
    }

    public function test_delivery_goes_through_supply_and_shipping_and_does_not_complete_when_handed_to_carrier(): void
    {
        [$order, $manager] = $this->order('delivery');
        foreach (['in_progress', 'confirmed', 'awaiting_supply', 'ready'] as $status) {
            $this->transition($order, $manager, $status)->assertSessionDoesntHaveErrors();
        }
        $this->assertSame('Готов к отправке', $order->fresh()->statusLabel());
        $this->transition($order, $manager, 'completed', ['fulfillment_confirmed' => '1'])->assertSessionHasErrors('status');
        $this->transition($order, $manager, 'shipped')->assertSessionDoesntHaveErrors();
        $this->assertSame('shipped', $order->fresh()->status);
        $this->get($order->customerUrl())->assertSee('Отправлен')->assertSee('Ожидаем получения покупателем');
        $this->transition($order, $manager, 'cancelled')->assertSessionHasErrors('status');
        $this->transition($order, $manager, 'in_progress')->assertSessionHasErrors('status');
        $this->transition($order, $manager, 'completed')->assertSessionHasErrors('fulfillment_confirmed');
        $this->transition($order, $manager, 'completed', ['fulfillment_confirmed' => '1'])->assertSessionDoesntHaveErrors();
        $this->assertSame('completed', $order->fresh()->status);
    }

    public function test_agreed_delivery_method_controls_ready_label_and_transitions(): void
    {
        foreach ([['pickup', 'delivery'], ['delivery', 'pickup']] as [$original, $agreed]) {
            [$order, $manager] = $this->order($agreed, $original);
            foreach (['in_progress', 'confirmed', 'ready'] as $status) {
                $this->transition($order, $manager, $status)->assertSessionDoesntHaveErrors();
            }
            $fresh = $order->fresh();
            $this->assertSame($original, $fresh->delivery_method);
            $this->assertSame($agreed, $fresh->effectiveDeliveryMethod());
            $this->assertSame($agreed === 'delivery' ? 'Готов к отправке' : 'Готов к выдаче', $fresh->statusLabel());
            $this->get($order->customerUrl())->assertSee($fresh->statusLabel());
            $target = $agreed === 'delivery' ? 'completed' : 'shipped';
            $this->transition($order, $manager, $target, ['fulfillment_confirmed' => '1'])->assertSessionHasErrors('status');
        }
    }

    public function test_latest_conditions_must_be_accepted_and_stale_manager_form_cannot_progress(): void
    {
        [$order, $manager] = $this->order();
        $this->transition($order, $manager, 'in_progress')->assertSessionDoesntHaveErrors();
        $this->transition($order, $manager, 'confirmed')->assertSessionDoesntHaveErrors();
        $proposal = app(OrderTerms::class)->propose($order, $manager, $this->termsData($order));
        $this->transition($order, $manager, 'ready')->assertSessionHasErrors('status');
        app(OrderTerms::class)->accept($order, $proposal->version);
        $this->transition($order, $manager, 'ready', ['expected_terms_version' => 1])->assertSessionHasErrors('expected_terms_version');
        $this->transition($order, $manager, 'ready')->assertSessionDoesntHaveErrors();
        $this->assertSame('ready', $order->fresh()->status);
    }

    public function test_unchanged_initial_request_does_not_require_repeated_acceptance(): void
    {
        [$order, $manager] = $this->order();
        $order->termsVersions()->delete();
        $order->update(['status' => 'confirmed']);
        $this->actingAs($manager)->get(route('admin.orders.show', $order))->assertDontSee('покупатель должен подтвердить')
            ->assertSee('name="status" value="ready"', false);
        $this->transition($order, $manager, 'ready')->assertSessionDoesntHaveErrors();
        $this->assertSame('ready', $order->fresh()->status);
    }

    public function test_ready_order_must_return_to_processing_before_terms_can_be_changed(): void
    {
        [$order, $manager] = $this->order();
        $order->update(['status' => 'ready']);
        $this->actingAs($manager)->post(route('admin.orders.terms.store', $order), $this->termsData($order))
            ->assertSessionHasErrors('terms');
        $this->get(route('admin.orders.show', $order))->assertDontSee('Сохранить изменения для согласования');
        $this->transition($order, $manager, 'in_progress')->assertSessionDoesntHaveErrors();
        $this->post(route('admin.orders.terms.store', $order), $this->termsData($order))->assertSessionDoesntHaveErrors();
        $this->assertSame(2, $order->termsVersions()->count());
    }

    public function test_new_statuses_appear_in_filters_and_history_uses_the_actual_ready_label(): void
    {
        [$order, $manager] = $this->order('delivery');
        $order->update(['status' => 'awaiting_supply']);
        $this->actingAs($manager)->get(route('admin.orders.index', ['status' => 'awaiting_supply']))
            ->assertOk()->assertSee($order->number)->assertSee('Ожидает поставки')->assertSee('Отправлен');
        $this->transition($order, $manager, 'ready')->assertSessionDoesntHaveErrors();
        $this->assertTrue(AdminActivityLog::query()->where('description', 'like', '%«Ожидает поставки» → «Готов к отправке»%')->exists());
        $this->get(route('admin.orders.index', ['status' => 'ready']))->assertSee('Готов к отправке');
        $this->get(route('admin.orders.show', $order))->assertSee('Передан службе доставки');
    }

    private function order(string $agreed = 'pickup', string $original = 'pickup'): array
    {
        $manager = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER, 'permissions' => [User::PERMISSION_ORDERS]]);
        $order = Order::query()->create([
            'number' => 'TEST-'.$manager->id, 'customer_name' => 'Покупатель', 'phone' => '+79000000000',
            'delivery_method' => $original, 'total' => '100.00', 'status' => 'new',
        ]);
        $order->items()->create(['product_name' => 'Товар', 'unit_price' => '100.00', 'quantity' => 1, 'total' => '100.00']);
        $data = $this->termsData($order);
        $data['delivery_method'] = $agreed;
        $terms = app(OrderTerms::class)->propose($order, $manager, $data);
        app(OrderTerms::class)->accept($order, $terms->version);

        return [$order, $manager];
    }

    private function termsData(Order $order): array
    {
        return [
            'expected_status' => $order->fresh()->status, 'expected_version' => (int) $order->termsVersions()->max('version'),
            'items' => [$order->items()->first()->id => ['quantity' => 1, 'supply_terms' => 'В наличии']],
            'delivery_method' => 'pickup', 'delivery_address' => 'Пермь', 'delivery_cost' => '0', 'delivery_terms' => 'После сборки',
            'payment_method' => 'cash', 'payment_terms' => 'По согласованию', 'change_reason' => 'Уточнение условий',
        ];
    }

    private function transition(Order $order, User $manager, string $target, array $extra = []): TestResponse
    {
        return $this->actingAs($manager)->put(route('admin.orders.update', $order), array_replace([
            'status' => $target, 'expected_status' => $order->fresh()->status,
            'expected_terms_version' => (int) $order->termsVersions()->max('version'),
        ], $extra));
    }
}

<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\Order;
use App\Models\OrderTermsVersion;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTermsAcceptanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_sees_items_and_can_accept_the_exact_proposal_without_logging_in(): void
    {
        config(['services.yandex_metrika.counter_id' => 123456]);
        $order = $this->order();
        $terms = $this->propose($order);
        $this->assertGuest();
        $before = $order->fresh()->getAttributes();

        $this->get($order->customerUrl())->assertOk()->assertSee('Исходный товар')
            ->assertSee('Предложение менеджера № 1')->assertSee('Проверить сроки поставки')
            ->assertSee('Подтвердить условия')->assertDontSee('metrika-config', false)
            ->assertDontSee($terms->created_by_name);
        $this->post($this->acceptUrl($order), ['version' => 1, 'accept_terms' => '1'])
            ->assertRedirect($order->customerUrl())->assertSessionDoesntHaveErrors();

        $this->assertNotNull($terms->fresh()->accepted_at);
        $this->assertSame('customer_link', $terms->fresh()->accepted_via);
        $this->assertSame($before, $order->fresh()->getAttributes());
        $this->assertSame(1, $this->acceptanceLogs());
        $this->get($order->customerUrl())->assertSee('Согласованные условия № 1')->assertDontSee('Подтвердить условия');
    }

    public function test_explicit_consent_is_required_and_repeated_acceptance_has_no_duplicate_history(): void
    {
        $order = $this->order();
        $terms = $this->propose($order);
        foreach ([[], ['accept_terms' => '0']] as $input) {
            $this->post($this->acceptUrl($order), ['version' => 1, ...$input])
                ->assertRedirect($order->customerUrl())->assertSessionHasErrors('accept_terms');
        }
        $this->assertNull($terms->fresh()->accepted_at);
        $this->post($this->acceptUrl($order), ['version' => 1, 'accept_terms' => '1'])->assertSessionDoesntHaveErrors();
        $accepted = $terms->fresh()->getAttributes();
        $this->travel(1)->minutes();
        $this->post($this->acceptUrl($order), ['version' => 1, 'accept_terms' => '1'])->assertSessionDoesntHaveErrors();
        $this->assertSame($accepted, $terms->fresh()->getAttributes());
        $this->assertSame(1, $this->acceptanceLogs());
    }

    public function test_outdated_version_cannot_accept_the_replacement_or_change_previous_agreement(): void
    {
        $order = $this->order();
        $first = $this->propose($order);
        $this->get($order->customerUrl())->assertOk();
        $second = $this->propose($order, ['delivery_cost' => '50.10']);

        $this->post($this->acceptUrl($order), ['version' => 1, 'accept_terms' => '1'])
            ->assertRedirect($order->customerUrl())->assertSessionHasErrors('version');
        $this->assertNull($first->fresh()->accepted_at);
        $this->assertNull($second->fresh()->accepted_at);
        $this->assertSame(0, $this->acceptanceLogs());
    }

    public function test_adjusted_quantities_and_prices_require_fresh_acceptance_and_preserve_old_terms(): void
    {
        $order = $this->order();
        $first = $this->propose($order);
        $this->post($this->acceptUrl($order), ['version' => 1, 'accept_terms' => '1'])->assertSessionDoesntHaveErrors();
        $original = $first->fresh()->getAttributes();
        $id = $order->items->first()->id;
        $second = $this->propose($order, [
            'items' => [$id => ['quantity' => 3, 'unit_price' => '90.05']],
            'delivery_cost' => '30.10', 'change_reason' => 'Добавлен товар и согласована скидка',
        ]);

        $this->assertNull($second->accepted_at);
        $this->assertSame($original, $first->fresh()->getAttributes());
        $this->assertSame(1, $second->baseline_version);
        $this->assertSame('270.15', $second->goods_total);
        $this->assertSame('69.85', $second->goods_difference);
        $this->assertSame('10.05', $second->delivery_difference);
        $this->assertSame('79.90', $second->total_difference);
        $this->get($order->customerUrl())->assertSee('Согласованные условия № 1')
            ->assertSee('Предложение менеджера № 2')->assertSee('+79,90 ₽');
        $this->post($this->acceptUrl($order), ['version' => 2, 'accept_terms' => '1'])->assertSessionDoesntHaveErrors();
        $this->assertNotNull($second->fresh()->accepted_at);
        $this->assertSame($original, $first->fresh()->getAttributes());
        $this->assertSame('200.30', $order->fresh()->total);
        $this->assertSame(2, $order->items()->first()->quantity);
        $this->get($order->customerUrl())->assertSee('Согласованные условия № 2')->assertDontSee('Подтвердить условия');
    }

    public function test_replacement_uses_catalog_snapshot_and_keeps_original_items_and_negative_difference(): void
    {
        $order = $this->order();
        $replacement = $this->product();
        $id = $order->items->first()->id;
        $terms = $this->propose($order, [
            'items' => [$id => ['quantity' => 0]],
            'additional_items' => [$replacement->id => ['quantity' => 1, 'unit_price' => '120.05', 'supply_terms' => 'В наличии']],
            'change_reason' => 'Замена на другой товар по предложению менеджера',
        ]);
        $this->assertSame(0, $terms->items[0]['quantity']);
        $this->assertSame('Товар для замены', $terms->items[1]['product_name']);
        $this->assertNull($terms->items[1]['order_item_id']);
        $this->assertSame('-80.25', $terms->goods_difference);
        $this->assertSame('-60.20', $terms->total_difference);
        $replacement->update(['name' => 'Новое имя в каталоге', 'price' => '999.00']);
        $this->get($order->customerUrl())->assertSee('Товар для замены')->assertDontSee('Новое имя в каталоге');
        $this->post($this->acceptUrl($order), ['version' => 1, 'accept_terms' => '1'])->assertSessionDoesntHaveErrors();
        $this->assertSame(1, $order->items()->count());
        $this->assertSame('Исходный товар', $order->items()->first()->product_name);
    }

    public function test_unknown_delivery_does_not_turn_into_a_zero_total_or_a_claim_of_payment(): void
    {
        $order = $this->order();
        $terms = $this->propose($order, ['delivery_cost' => null]);
        $this->assertSame('0.00', $terms->goods_difference);
        $this->assertNull($terms->delivery_difference);
        $this->assertNull($terms->total_difference);
        $this->get($order->customerUrl())->assertSee('Стоимость доставки ещё не рассчитана')
            ->assertSee('Будет определён после расчёта доставки');
        $this->post($this->acceptUrl($order), ['version' => 1, 'accept_terms' => '1'])->assertSessionDoesntHaveErrors();
        $this->assertNull($terms->fresh()->total);
        $this->assertSame('in_progress', $order->fresh()->status);
    }

    public function test_closed_orders_and_orders_without_proposals_cannot_be_accepted(): void
    {
        $order = $this->order();
        $this->post($this->acceptUrl($order), ['version' => 1, 'accept_terms' => '1'])->assertSessionHasErrors('version');
        $terms = $this->propose($order);
        foreach (['cancelled', 'completed'] as $status) {
            $order->update(['status' => $status]);
            $this->post($this->acceptUrl($order), ['version' => 1, 'accept_terms' => '1'])->assertSessionHasErrors('version');
            $this->get($order->customerUrl())->assertOk()->assertDontSee('Подтвердить условия');
        }
        $this->assertNull($terms->fresh()->accepted_at);
    }

    public function test_numeric_id_and_unknown_token_cannot_grant_acceptance_access(): void
    {
        $order = $this->order();
        $terms = $this->propose($order);
        foreach ([$order->id, $order->checkout_token, str_repeat('0', 64)] as $key) {
            $this->post('/checkout/'.$key.'/terms/accept', ['version' => 1, 'accept_terms' => '1'])->assertNotFound();
        }
        $this->get($this->acceptUrl($order))->assertStatus(405);
        $this->assertNull($terms->fresh()->accepted_at);
    }

    public function test_invalid_additions_and_missing_change_reason_cannot_create_a_version(): void
    {
        $order = $this->order();
        $inactive = $this->product();
        $inactive->update(['is_active' => false]);
        $this->actingAs($this->manager());
        foreach (['invalid', $inactive->id, 999999] as $key) {
            $data = $this->data($order);
            $data['additional_items'] = [$key => ['quantity' => 1, 'unit_price' => '1.00', 'supply_terms' => 'В наличии']];
            $this->post(route('admin.orders.terms.store', $order), $data)->assertSessionHasErrors('additional_items');
        }
        $data = $this->data($order);
        unset($data['change_reason']);
        $this->post(route('admin.orders.terms.store', $order), $data)->assertSessionHasErrors('change_reason');
        $this->assertDatabaseCount('order_terms_versions', 0);
    }

    public function test_manager_can_search_catalog_and_form_keeps_the_latest_replacement_and_prices(): void
    {
        $order = $this->order();
        $product = $this->product();
        $this->actingAs($this->manager())->get(route('admin.orders.show', [$order, 'product_search' => 'замены']))
            ->assertOk()->assertSee('Товар для замены')->assertSee('additional_items['.$product->id.'][quantity]', false);
        $this->propose($order, ['additional_items' => [$product->id => ['quantity' => 2, 'unit_price' => '110.05', 'supply_terms' => 'На следующей неделе']]]);
        $this->actingAs($this->manager())->get(route('admin.orders.show', $order))->assertOk()
            ->assertSee('additional_items['.$product->id.'][quantity]', false)->assertSee('value="110.05"', false)
            ->assertSee('name="items['.$order->items->first()->id.'][unit_price]"', false)
            ->assertSee('На следующей неделе');
    }

    public function test_small_negative_adjustments_are_exact_and_invalid_form_keeps_selected_additions(): void
    {
        $order = $this->order();
        $id = $order->items->first()->id;
        $terms = $this->propose($order, [
            'items' => [$id => ['unit_price' => '100.10']], 'delivery_method' => 'pickup', 'delivery_cost' => '0',
        ]);
        $this->assertSame('-0.10', $terms->goods_difference);
        $this->assertSame('-0.10', $terms->total_difference);

        $product = $this->product();
        $data = $this->data($order);
        $data['change_reason'] = '';
        $data['additional_items'] = [$product->id => ['quantity' => 1, 'unit_price' => '110.05', 'supply_terms' => 'В наличии']];
        $this->actingAs($this->manager())->from(route('admin.orders.show', $order))
            ->post(route('admin.orders.terms.store', $order), $data)->assertSessionHasErrors('change_reason');
        $this->get(route('admin.orders.show', $order))->assertOk()
            ->assertSee('additional_items['.$product->id.'][quantity]', false)->assertSee('value="110.05"', false);
    }

    private function propose(Order $order, array $changes = []): OrderTermsVersion
    {
        $data = array_replace_recursive($this->data($order), $changes);
        $this->actingAs($this->manager())->post(route('admin.orders.terms.store', $order), $data)
            ->assertSessionDoesntHaveErrors()->assertRedirect();
        auth()->forgetGuards();

        return $order->termsVersions()->first();
    }

    private function data(Order $order): array
    {
        return [
            'expected_version' => (int) $order->termsVersions()->max('version'), 'expected_status' => $order->fresh()->status,
            'items' => [$order->items->first()->id => ['quantity' => 2, 'supply_terms' => 'До 30.10.2026']],
            'delivery_method' => 'delivery', 'delivery_address' => 'Адрес доставки',
            'delivery_cost' => '20.05', 'delivery_terms' => 'Одна отправка после поступления',
            'payment_method' => 'bank_transfer', 'payment_terms' => 'Предоплата переводом, доставка отдельно',
            'change_reason' => 'Проверить сроки поставки',
        ];
    }

    private function order(): Order
    {
        $order = Order::query()->create([
            'number' => 'AB-001', 'customer_name' => 'Покупатель', 'phone' => '+79000000000',
            'email' => 'customer@example.test', 'delivery_method' => 'pickup', 'total' => '200.30', 'status' => 'in_progress',
            'checkout_token' => '00000000-0000-4000-8000-000000000001',
        ]);
        $order->items()->create(['product_name' => 'Исходный товар', 'unit_price' => '100.15', 'quantity' => 2, 'total' => '200.30']);

        return $order->load('items');
    }

    private function manager(): User
    {
        return User::factory()->create(['is_admin' => true, 'name' => 'Сотрудник магазина', 'role' => User::ROLE_CONTENT_MANAGER, 'permissions' => [User::PERMISSION_ORDERS]]);
    }

    private function product(): Product
    {
        return Product::query()->create(['name' => 'Товар для замены', 'slug' => 'replacement', 'price' => '130.05', 'is_active' => true, 'stock' => 1]);
    }

    private function acceptUrl(Order $order): string
    {
        return route('checkout.terms.accept', ['order' => $order->access_token]);
    }

    private function acceptanceLogs(): int
    {
        return AdminActivityLog::query()->where('user_name', 'Покупатель')->count();
    }
}

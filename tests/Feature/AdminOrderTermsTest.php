<?php

namespace Tests\Feature;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderTermsVersion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderTermsTest extends TestCase
{
    use RefreshDatabase;

    public function test_proposal_saves_an_independent_snapshot_and_calculates_money_without_changing_the_request(): void
    {
        $order = $this->order();
        $before = $order->refresh()->getAttributes();
        $originalItem = $order->items->first()->getAttributes();
        $data = $this->data($order);
        $data['items'][$order->items->first()->id]['quantity'] = 1;
        $data['accepted_at'] = now()->toDateTimeString();
        $data['goods_total'] = '1.00';
        $data['total'] = '1.00';

        $manager = $this->manager();
        $this->actingAs($manager)->post($this->url($order), $data)
            ->assertRedirect(route('admin.orders.show', $order))->assertSessionDoesntHaveErrors();

        $terms = $order->termsVersions()->sole();
        $this->assertSame('100.15', $terms->goods_total);
        $this->assertSame('20.05', $terms->delivery_cost);
        $this->assertSame('120.20', $terms->total);
        $this->assertSame($manager->id, $terms->created_by);
        $this->assertSame($manager->name, $terms->created_by_name);
        $this->assertSame('Доставка до 30.10.2026, одной отправкой', $terms->delivery_terms);
        $this->assertSame('Пермь, ул. Пример, 2', $terms->delivery_address);
        $this->assertSame('bank_transfer', $terms->payment_method);
        $this->assertSame($data['payment_terms'], $terms->payment_terms);
        $this->assertSame('До 29.10.2026', $terms->items[0]['supply_terms']);
        $this->assertNull($terms->accepted_at);
        $this->assertSame($before, $order->fresh()->getAttributes());
        $this->assertSame($originalItem, $order->items()->first()->getAttributes());
        $this->assertDatabaseHas('admin_activity_logs', ['subject_type' => 'order', 'subject_id' => $order->id, 'user_id' => $manager->id]);
        $this->get(route('admin.orders.show', $order))->assertOk()
            ->assertSee('Предложение менеджера')->assertSee('120,20 ₽')
            ->assertSee('Согласие покупателя на условия пока не зафиксировано')
            ->assertSee('Сохранено предложение условий №1');
    }

    public function test_revisions_are_appended_and_stale_updates_are_rejected(): void
    {
        $order = $this->order();
        $data = $this->data($order);
        $this->actingAs($this->manager())->post($this->url($order), $data)->assertSessionDoesntHaveErrors();
        $first = $order->termsVersions()->sole()->getAttributes();
        $this->post($this->url($order), $data)->assertSessionHasErrors('terms');
        $data['expected_version'] = 1;
        $data['payment_terms'] = 'Предоплата переводом до 28.10.2026';
        $this->post($this->url($order), $data)->assertSessionDoesntHaveErrors();

        $this->assertSame(2, $order->termsVersions()->count());
        $this->assertSame($first, OrderTermsVersion::query()->findOrFail($first['id'])->getAttributes());
        $this->assertSame(2, $order->termsVersions()->first()->version);
        $this->assertDatabaseCount('admin_activity_logs', 2);
    }

    public function test_unknown_delivery_is_distinct_from_free_delivery_and_pickup(): void
    {
        $order = $this->order();
        $data = $this->data($order);
        $data['delivery_cost'] = '';
        $this->actingAs($this->manager())->post($this->url($order), $data)->assertSessionDoesntHaveErrors();
        $unknown = $order->termsVersions()->first();
        $this->assertSame('200.30', $unknown->goods_total);
        $this->assertNull($unknown->delivery_cost);
        $this->assertNull($unknown->total);
        $this->get(route('admin.orders.show', $order))->assertSee('Пока не рассчитана')
            ->assertSee('Будет определён после расчёта доставки');

        $data['expected_version'] = 1;
        $data['delivery_cost'] = '0';
        $this->post($this->url($order), $data)->assertSessionDoesntHaveErrors();
        $this->assertSame('0.00', $order->termsVersions()->first()->delivery_cost);
        $this->assertSame('200.30', $order->termsVersions()->first()->total);

        $data['expected_version'] = 2;
        $data['delivery_method'] = 'pickup';
        $data['delivery_cost'] = '';
        $this->post($this->url($order), $data)->assertSessionDoesntHaveErrors();
        $pickup = $order->termsVersions()->first();
        $this->assertNull($pickup->delivery_address);
        $this->assertSame('0.00', $pickup->delivery_cost);
        $this->assertSame('200.30', $pickup->total);
        $this->assertNull($unknown->fresh()->total);
    }

    public function test_invalid_quantities_foreign_positions_and_forged_names_are_rejected(): void
    {
        $order = $this->order();
        $foreign = $this->order('AB-002');
        $data = $this->data($order);
        $id = $order->items->first()->id;
        $this->actingAs($this->manager());
        foreach ([-1, 0, 101, '1.5'] as $quantity) {
            $invalid = $data;
            $invalid['items'][$id]['quantity'] = $quantity;
            $this->post($this->url($order), $invalid)->assertSessionHasErrors();
        }
        $invalid = $data;
        $invalid['items'] = [$foreign->items->first()->id => $data['items'][$id]];
        $this->post($this->url($order), $invalid)->assertSessionHasErrors('items');
        $invalid = $data;
        $invalid['items'][$id]['product_name'] = 'Подменённое имя';
        $this->post($this->url($order), $invalid)->assertSessionHasErrors();
        $invalid = $data;
        $invalid['items'][$id]['supply_terms'] = '';
        $this->post($this->url($order), $invalid)->assertSessionHasErrors('items.'.$id.'.supply_terms');
        $this->assertDatabaseCount('order_terms_versions', 0);
        $this->assertDatabaseCount('admin_activity_logs', 0);
    }

    public function test_delivery_and_payment_require_complete_and_valid_conditions(): void
    {
        $order = $this->order();
        $data = $this->data($order);
        $this->actingAs($this->manager());
        foreach ([
            ['delivery_address' => ''], ['delivery_terms' => ''], ['payment_terms' => ''],
            ['payment_method' => 'online'], ['delivery_cost' => '-1'], ['delivery_cost' => '1.001'],
            ['delivery_cost' => '1e2'], ['delivery_cost' => '9999999999.99'],
            ['delivery_method' => 'pickup', 'delivery_cost' => '20.05'],
        ] as $invalid) {
            $this->post($this->url($order), array_replace($data, $invalid))->assertSessionHasErrors();
        }
        $this->assertDatabaseCount('order_terms_versions', 0);
    }

    public function test_each_original_position_must_be_explicitly_included_or_excluded(): void
    {
        $order = $this->order();
        $second = $order->items()->create(['product_name' => 'Вторая позиция', 'unit_price' => '9.95', 'quantity' => 1, 'total' => '9.95']);
        $order->update(['total' => '210.25']);
        $data = $this->data($order);
        $this->actingAs($this->manager())->post($this->url($order), $data)->assertSessionHasErrors('items');
        $data['items'][$second->id] = ['quantity' => 0, 'supply_terms' => ''];
        $this->post($this->url($order), $data)->assertSessionDoesntHaveErrors();

        $terms = $order->termsVersions()->sole();
        $this->assertCount(2, $terms->items);
        $this->assertSame(0, $terms->items[1]['quantity']);
        $this->assertSame('0.00', $terms->items[1]['total']);
        $this->assertSame('200.30', $terms->goods_total);
        $this->assertSame('210.25', $order->fresh()->total);
        $this->assertSame(1, $second->fresh()->quantity);
    }

    public function test_closed_and_concurrently_changed_orders_cannot_receive_proposals(): void
    {
        $order = $this->order();
        $data = $this->data($order);
        $this->actingAs($this->manager());
        foreach (['completed', 'cancelled'] as $status) {
            $order->update(['status' => $status]);
            $this->post($this->url($order), array_replace($data, ['expected_status' => $status]))
                ->assertSessionHasErrors('terms');
            $this->get(route('admin.orders.show', $order))->assertDontSee('Сохранить предложение');
        }
        $order->update(['status' => 'confirmed']);
        $this->post($this->url($order), $data)->assertSessionHasErrors('terms');
        $this->assertDatabaseCount('order_terms_versions', 0);
    }

    public function test_only_staff_with_order_permission_can_create_proposals(): void
    {
        $order = $this->order();
        $this->post($this->url($order), $this->data($order))->assertRedirect(route('login'));
        foreach ([User::factory()->create(), User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER])] as $user) {
            $this->actingAs($user)->post($this->url($order), $this->data($order))->assertForbidden();
        }
        $this->assertDatabaseCount('order_terms_versions', 0);
    }

    public function test_author_name_and_terms_survive_deletion_of_the_manager(): void
    {
        $order = $this->order();
        $manager = $this->manager();
        $this->actingAs($manager)->post($this->url($order), $this->data($order))->assertSessionDoesntHaveErrors();
        $manager->delete();

        $terms = $order->termsVersions()->sole();
        $this->assertNull($terms->created_by);
        $this->assertSame($manager->name, $terms->created_by_name);
        $this->assertSame('220.35', $terms->total);
    }

    public function test_existing_accepted_conditions_are_preserved_when_a_new_proposal_is_saved(): void
    {
        $order = $this->order();
        $data = $this->data($order);
        $this->actingAs($this->manager())->post($this->url($order), $data)->assertSessionDoesntHaveErrors();
        $accepted = $order->termsVersions()->sole();
        $accepted->forceFill(['accepted_at' => now()])->save();
        $before = $accepted->getAttributes();
        $this->post($this->url($order), array_replace($data, ['expected_version' => 1, 'delivery_cost' => '30.00']))
            ->assertSessionDoesntHaveErrors();
        $this->assertSame($before, $accepted->fresh()->getAttributes());
        $this->assertNull($order->termsVersions()->first()->accepted_at);
        $this->get(route('admin.orders.show', $order))->assertSee('Действующие согласованные условия: версия № 1');
    }

    public function test_original_policy_is_rendered_from_the_saved_snapshot_and_legacy_orders_are_marked(): void
    {
        $order = $this->order();
        $this->actingAs($this->manager())->get(route('admin.orders.show', $order))
            ->assertSee('Текст условий при оформлении этого заказа не был сохранён');
        $order->update(['checkout_terms' => ['version' => 'old-policy', 'notices' => ['Исходный порядок оплаты этого заказа']]]);
        $this->get(route('admin.orders.show', $order))->assertSee('old-policy')
            ->assertSee('Исходный порядок оплаты этого заказа');
        $email = (new OrderConfirmation($order))->render();
        $this->assertStringContainsString('Исходный порядок оплаты этого заказа', $email);
        $this->assertStringNotContainsString('Предусмотрена 100% предоплата всех товаров', $email);
        $this->get($order->customerUrl())->assertSee('Исходный порядок оплаты этого заказа')
            ->assertDontSee('Предусмотрена 100% предоплата всех товаров');
    }

    private function manager(): User
    {
        return User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER, 'permissions' => [User::PERMISSION_ORDERS]]);
    }

    private function order(string $number = 'AB-001'): Order
    {
        $order = Order::query()->create([
            'number' => $number, 'customer_name' => 'Покупатель', 'phone' => '+79000000000',
            'email' => 'customer@example.test', 'delivery_method' => 'pickup', 'total' => '200.30', 'status' => 'in_progress',
        ]);
        $order->items()->create(['product_name' => 'Товар из заявки', 'unit_price' => '100.15', 'quantity' => 2, 'total' => '200.30']);

        return $order->load('items');
    }

    private function data(Order $order): array
    {
        return [
            'expected_version' => 0, 'expected_status' => $order->status, 'change_reason' => 'Первичное предложение условий',
            'items' => [$order->items->first()->id => ['quantity' => 2, 'supply_terms' => 'До 29.10.2026']],
            'delivery_method' => 'delivery', 'delivery_address' => 'Пермь, ул. Пример, 2',
            'delivery_terms' => 'Доставка до 30.10.2026, одной отправкой', 'delivery_cost' => '20.05',
            'payment_method' => 'bank_transfer', 'payment_terms' => 'Предоплата товаров переводом, доставка при получении',
        ];
    }

    private function url(Order $order): string
    {
        return route('admin.orders.terms.store', $order);
    }
}

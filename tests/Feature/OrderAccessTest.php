<?php

namespace Tests\Feature;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OrderAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_thanks_and_open_order_require_the_original_checkout_session(): void
    {
        $order = $this->order();

        foreach (['checkout.thanks', 'checkout.open-order'] as $route) {
            $this->get(route($route, ['order' => $order->id, 'access_token' => $order->access_token]))
                ->assertNotFound();
        }
        $this->withSession(['checkout.completed_order_id' => $order->id + 1]);
        $this->get(route('checkout.thanks'))->assertNotFound();
        $this->get(route('checkout.open-order'))->assertNotFound();
    }

    public function test_open_order_uses_the_session_and_ignores_a_different_order_in_the_url(): void
    {
        $first = $this->order();
        $second = $this->order('AB-000002');

        $this->withSession(['checkout.completed_order_id' => $first->id])
            ->get(route('checkout.open-order', ['order' => $second->id, 'access_token' => $second->access_token]))
            ->assertRedirect($first->customerUrl());
    }

    public function test_secret_link_works_without_the_checkout_session(): void
    {
        config(['services.yandex_metrika.counter_id' => 123456]);
        $order = $this->order();

        $this->get($order->customerUrl())->assertOk()
            ->assertSee($order->number)
            ->assertHeader('Referrer-Policy', 'no-referrer')
            ->assertHeader('Cache-Control', 'no-store, private')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertSee('<meta name="robots" content="noindex,nofollow">', false)
            ->assertDontSee('metrika-config', false)
            ->assertDontSee('js/analytics.js', false);
    }

    public function test_numeric_id_order_number_checkout_token_and_unknown_token_do_not_grant_access(): void
    {
        $order = $this->order();
        $order->update(['checkout_token' => 'f43b3c52-bbfd-41fc-9f90-8e4fb2c44031']);

        foreach ([$order->id, $order->number, $order->checkout_token, str_repeat('0', 64), substr($order->access_token, 0, 63)] as $key) {
            $this->get('/checkout/'.$key.'/success')->assertNotFound()->assertDontSee($order->number);
        }
    }

    public function test_each_order_has_its_own_secret_link_and_tokens_are_hidden_from_serialization(): void
    {
        $first = $this->order();
        $second = $this->order('AB-000002');

        $this->assertMatchesRegularExpression('/\A[a-f0-9]{64}\z/', $first->access_token);
        $this->assertNotSame($first->access_token, $second->access_token);
        $this->assertArrayNotHasKey('access_token', $first->toArray());
        $this->assertArrayNotHasKey('checkout_token', $first->toArray());
        $this->get($second->customerUrl())->assertOk()->assertSee($second->number)->assertDontSee($first->number);
        $this->assertSame((string) $first->id, (string) $first->getRouteKey());
    }

    public function test_customer_email_contains_the_secret_link(): void
    {
        $order = $this->order();

        $this->assertStringContainsString($order->customerUrl(), (new OrderConfirmation($order))->render());
    }

    public function test_migration_assigns_tokens_to_existing_orders_without_changing_their_terms(): void
    {
        $migration = require database_path('migrations/2026_10_23_000000_add_access_token_to_orders_table.php');
        $migration->down();
        $id = DB::table('orders')->insertGetId([
            'number' => 'AB-000001', 'customer_name' => 'Покупатель', 'phone' => '+79001234567',
            'email' => 'customer@example.test', 'delivery_method' => 'pickup', 'total' => '1000.00',
        ]);
        $before = (array) DB::table('orders')->find($id);

        $migration->up();

        $order = Order::query()->findOrFail($id);
        $this->assertMatchesRegularExpression('/\A[a-f0-9]{64}\z/', $order->access_token);
        $after = (array) DB::table('orders')->find($id);
        unset($after['access_token']);
        $this->assertSame($before, $after);
        $this->get($order->customerUrl())->assertOk();
        $this->get('/checkout/'.$id.'/success')->assertNotFound();
    }

    private function order(string $number = 'AB-000001'): Order
    {
        return Order::query()->create([
            'number' => $number, 'customer_name' => 'Покупатель', 'phone' => '+79001234567',
            'email' => 'customer@example.test', 'delivery_method' => 'pickup', 'total' => '1000.00',
        ]);
    }
}

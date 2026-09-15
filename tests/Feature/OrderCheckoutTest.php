<?php

namespace Tests\Feature;

use App\Mail\CallbackRequested;
use App\Mail\OrderConfirmation;
use App\Mail\OrderCreated;
use App\Models\CallbackRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
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
        Mail::assertQueued(OrderCreated::class, fn (OrderCreated $mail) => $mail->order->is($order));
        Mail::assertQueued(OrderConfirmation::class, fn (OrderConfirmation $mail) => $mail->order->is($order));
        $this->assertEmpty(session('cart.items', []));
    }

    public function test_delivery_address_is_required_for_delivery(): void
    {
        $this->post(route('cart.store', $this->product()));

        $this->from(route('checkout.create'))
            ->post(route('checkout.store'), [
                'customer_name' => 'Иван Петров',
                'phone' => '+7 900 123-45-67',
                'email' => 'ivan@example.com',
                'delivery_method' => 'delivery',
            ])
            ->assertRedirect(route('checkout.create'))
            ->assertSessionHasErrors('delivery_address');
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
        $this->actingAs($admin)->put(route('admin.orders.update', $order), ['status' => Order::STATUS_CONFIRMED])
            ->assertRedirect(route('admin.orders.show', $order));

        $this->assertSame(Order::STATUS_CONFIRMED, $order->fresh()->status);
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
            ->assertSee('На сумму: 20 000,00 ₽')
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
        Mail::assertQueued(CallbackRequested::class, fn (CallbackRequested $mail) => $mail->callbackRequest->is($callbackRequest));
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
            ->put(route('admin.callback-requests.update', $callbackRequest), ['status' => CallbackRequest::STATUS_IN_PROGRESS])
            ->assertRedirect(route('admin.callback-requests.show', $callbackRequest));

        $this->assertSame(CallbackRequest::STATUS_IN_PROGRESS, $callbackRequest->fresh()->status);
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
}

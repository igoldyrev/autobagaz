<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutOrderRequest;
use App\Mail\OrderConfirmation;
use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(CartService $cart): View|RedirectResponse
    {
        $items = $cart->contents();
        if ($items->isEmpty()) {
            return to_route('cart.index')->with('error', 'Добавьте товар в корзину, чтобы оформить заказ.');
        }

        return view('checkout.create', ['items' => $items, 'total' => $cart->total()]);
    }

    public function store(CheckoutOrderRequest $request, CartService $cart): RedirectResponse
    {
        $cartItems = $cart->contents();
        if ($cartItems->isEmpty()) {
            return to_route('cart.index')->with('error', 'Корзина пуста.');
        }

        $order = DB::transaction(function () use ($request, $cartItems) {
            $products = Product::query()->active()->lockForUpdate()
                ->whereIn('id', $cartItems->pluck('product.id'))
                ->get()->keyBy('id');

            if ($products->count() !== $cartItems->count()) {
                abort(422, 'Один из товаров больше недоступен. Обновите корзину и попробуйте снова.');
            }

            $items = $cartItems->map(function (array $item) use ($products): array {
                $product = $products->get($item['product']->id);
                $unitPrice = (float) $product->price;

                return [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $item['quantity'],
                    'total' => $unitPrice * $item['quantity'],
                ];
            });

            $order = Order::query()->create([
                ...$request->safe()->except('website'),
                'total' => $items->sum('total'),
            ]);
            $order->update(['number' => sprintf('AB-%06d', $order->id)]);
            $order->items()->createMany($items->all());

            return $order->load('items');
        });

        $cart->clear();
        Mail::to(config('orders.notification_email'))->queue(new OrderCreated($order));
        Mail::to($order->email)->queue(new OrderConfirmation($order));

        return to_route('checkout.success', $order)
            ->with('success', 'Заказ принят. Мы свяжемся с вами для подтверждения.')
            ->with('metrika_goal', [
                'name' => 'order_created',
                'params' => [
                    'order_price' => (float) $order->total,
                    'currency' => 'RUB',
                ],
            ]);
    }

    public function success(Order $order): View
    {
        return view('checkout.success', compact('order'));
    }
}

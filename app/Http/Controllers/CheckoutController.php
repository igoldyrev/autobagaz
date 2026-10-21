<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutOrderRequest;
use App\Models\InstallationService;
use App\Models\Order;
use App\Models\Product;
use App\Models\VehicleConfiguration;
use App\Services\CartService;
use App\Services\OrderNotifications;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(Request $request, CartService $cart): View|RedirectResponse
    {
        $items = $cart->contents();
        if ($items->isEmpty()) {
            return to_route('cart.index')->with('error', 'Добавьте товар в корзину, чтобы оформить заказ.');
        }

        $installationService = $cart->selectedInstallationService();
        $checkoutToken = $request->session()->get(CheckoutOrderRequest::TOKEN_SESSION_KEY);
        if (! $checkoutToken || Order::query()->where('checkout_token', $checkoutToken)->exists()) {
            $checkoutToken = (string) Str::uuid();
            $request->session()->put(CheckoutOrderRequest::TOKEN_SESSION_KEY, $checkoutToken);
        }

        return view('checkout.create', compact('items', 'installationService', 'checkoutToken') + ['total' => $cart->total($installationService)]);
    }

    public function store(CheckoutOrderRequest $request, CartService $cart, OrderNotifications $notifications): RedirectResponse
    {
        $checkoutToken = $request->validated('checkout_token');
        $existingOrder = Order::query()->where('checkout_token', $checkoutToken)->first();
        if ($existingOrder) {
            return to_route('checkout.success', $existingOrder);
        }

        $cartItems = $cart->contents();
        $selectedInstallationService = $cart->selectedInstallationService();
        if ($cartItems->isEmpty()) {
            return to_route('cart.index')->with('error', 'Корзина пуста.');
        }

        try {
            $order = DB::transaction(function () use ($request, $cartItems, $selectedInstallationService, $notifications) {
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

                if ($selectedInstallationService) {
                    $installationService = InstallationService::query()->available()->lockForUpdate()->first();

                    if ($installationService) {
                        $items->push([
                            'product_id' => null,
                            'product_name' => $installationService->name,
                            'unit_price' => (float) $installationService->price,
                            'quantity' => 1,
                            'total' => (float) $installationService->price,
                        ]);
                    }
                }

                $order = Order::query()->create([
                    ...$request->safe()->except('website'),
                    'total' => $items->sum('total'),
                    'vehicle_snapshot' => $this->vehicleSnapshot($request),
                ]);
                $order->update(['number' => sprintf('AB-%06d', $order->id)]);
                $order->items()->createMany($items->all());
                $notifications->recordOrder($order);

                return $order->load('items');
            });
        } catch (UniqueConstraintViolationException $exception) {
            // A concurrent submission may have committed this checkout first.
            $existingOrder = Order::query()->where('checkout_token', $checkoutToken)->first();
            if (! $existingOrder) {
                throw $exception;
            }

            return to_route('checkout.success', $existingOrder);
        }

        $cart->clear();
        $notifications->dispatchPending(orderId: $order->id);

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

    /** @return array<string, int|string|null>|null */
    private function vehicleSnapshot(Request $request): ?array
    {
        $vehicle = $request->attributes->get('vehicleConfiguration');
        if (! $vehicle instanceof VehicleConfiguration) {
            return null;
        }

        $year = $request->attributes->get('vehicleYear');

        return [
            'configuration_id' => $vehicle->id,
            'label' => $vehicle->labelForYear($year),
            'make' => $vehicle->generation?->vehicleModel?->make?->name,
            'model' => $vehicle->generation?->vehicleModel?->name,
            'generation' => $vehicle->generation?->display_name,
            'configuration' => $vehicle->display_name,
            'body_style' => $vehicle->bodyStyle?->name,
            'roof_type' => $vehicle->roofType?->name,
            'year' => $year,
        ];
    }
}

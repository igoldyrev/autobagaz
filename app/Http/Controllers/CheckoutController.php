<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutOrderRequest;
use App\Models\Order;
use App\Models\VehicleConfiguration;
use App\Services\CartService;
use App\Services\OrderNotifications;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use JsonException;

class CheckoutController extends Controller
{
    public function create(Request $request, CartService $cart): View|RedirectResponse
    {
        $snapshot = $cart->checkoutSnapshot();
        $previous = $request->session()->get('checkout.previous');
        if ($snapshot === [] && ! $previous && ! $request->old('checkout_snapshot')) {
            return to_route('cart.index')->with('error', 'Добавьте товар в корзину, чтобы оформить заказ.');
        }

        $checkoutToken = $request->session()->get(CheckoutOrderRequest::TOKEN_SESSION_KEY);
        if (! $checkoutToken || Order::query()->where('checkout_token', $checkoutToken)->exists()) {
            $checkoutToken = (string) Str::uuid();
            $request->session()->put(CheckoutOrderRequest::TOKEN_SESSION_KEY, $checkoutToken);
        }

        // Validation errors must not hide changes that happened since the form was shown.
        $oldSnapshot = $request->old('checkout_snapshot');
        if (! $previous && is_string($oldSnapshot)) {
            try {
                $oldSnapshot = json_decode(Crypt::decryptString($oldSnapshot), true, 512, JSON_THROW_ON_ERROR);
                if (($oldSnapshot['token'] ?? null) === $checkoutToken && is_array($oldSnapshot['items'] ?? null)) {
                    $previous = $oldSnapshot['items'];
                }
            } catch (DecryptException|JsonException $exception) {
                // An invalid snapshot is reported by CheckoutOrderRequest; render fresh conditions.
            }
        }

        $changes = $previous ? $cart->checkoutChanges($previous, $snapshot) : [];
        $checkoutSnapshot = Crypt::encryptString(json_encode(['token' => $checkoutToken, 'items' => $snapshot], JSON_THROW_ON_ERROR));
        $total = array_sum(array_map(fn (array $item) => $item['price'] * $item['quantity'], $snapshot));
        $installationService = collect($snapshot)->first(fn (array $item) => $item['product_id'] === null);

        return view('checkout.create', compact('snapshot', 'installationService', 'checkoutToken', 'checkoutSnapshot', 'changes', 'total'));
    }

    public function store(CheckoutOrderRequest $request, CartService $cart, OrderNotifications $notifications): RedirectResponse
    {
        $checkoutToken = $request->validated('checkout_token');
        $existingOrder = Order::query()->where('checkout_token', $checkoutToken)->first();
        if ($existingOrder) {
            return to_route('checkout.success', $existingOrder);
        }

        $confirmed = json_decode(Crypt::decryptString($request->validated('checkout_snapshot')), true, 512, JSON_THROW_ON_ERROR)['items'];

        try {
            $order = DB::transaction(function () use ($request, $cart, $confirmed, $notifications) {
                $snapshot = $cart->checkoutSnapshot(lock: true);
                // Another submission may have completed while we waited for the product locks.
                $existingOrder = Order::query()->where('checkout_token', $request->validated('checkout_token'))->first();
                if ($existingOrder) {
                    return to_route('checkout.success', $existingOrder);
                }
                if ($snapshot !== $confirmed || $snapshot === []) {
                    return $snapshot;
                }

                $items = collect($snapshot)->map(fn (array $item) => [
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'unit_price' => number_format($item['price'] / 100, 2, '.', ''),
                    'quantity' => $item['quantity'],
                    'total' => number_format($item['price'] * $item['quantity'] / 100, 2, '.', ''),
                ]);

                $order = Order::query()->create([
                    ...$request->safe()->except(['website', 'checkout_snapshot']),
                    'total' => number_format(array_sum(array_map(fn (array $item) => $item['price'] * $item['quantity'], $snapshot)) / 100, 2, '.', ''),
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

        if ($order instanceof RedirectResponse) {
            return $order;
        }

        if (is_array($order)) {
            return to_route('checkout.create')
                ->withInput($request->except(['_token', 'website', 'checkout_snapshot']))
                ->with('checkout.previous', $confirmed);
        }

        $request->session()->forget('checkout.previous');
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptOrderTermsRequest;
use App\Http\Requests\CheckoutOrderRequest;
use App\Models\Order;
use App\Models\VehicleConfiguration;
use App\Services\CartService;
use App\Services\OrderNotifications;
use App\Services\OrderTerms;
use App\Support\OrderCheckoutTerms;
use App\Support\PersonalDataConsent;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            return $this->redirectToThanks($request, $existingOrder);
        }

        $confirmed = json_decode(Crypt::decryptString($request->validated('checkout_snapshot')), true, 512, JSON_THROW_ON_ERROR)['items'];

        try {
            $order = DB::transaction(function () use ($request, $cart, $confirmed, $notifications) {
                $snapshot = $cart->checkoutSnapshot(lock: true);
                // Another submission may have completed while we waited for the product locks.
                $existingOrder = Order::query()->where('checkout_token', $request->validated('checkout_token'))->first();
                if ($existingOrder) {
                    return $this->redirectToThanks($request, $existingOrder);
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
                    ...$request->safe()->except(['website', 'checkout_snapshot', 'personal_data_consent', 'consent_version']),
                    ...PersonalDataConsent::attributes(),
                    'total' => number_format(array_sum(array_map(fn (array $item) => $item['price'] * $item['quantity'], $snapshot)) / 100, 2, '.', ''),
                    'vehicle_snapshot' => $this->vehicleSnapshot($request),
                    'checkout_terms' => OrderCheckoutTerms::snapshot(),
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

            return $this->redirectToThanks($request, $existingOrder);
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

        $request->session()->put('checkout.created_order_id', $order->id);

        return $this->redirectToThanks($request, $order);
    }

    public function thanks(Request $request): Response
    {
        $order = $this->sessionOrder($request);
        $checkoutGoal = $request->session()->pull('checkout.created_order_id') === $order->id
            ? ['name' => 'order_created', 'params' => ['order_price' => (float) $order->total, 'currency' => 'RUB']]
            : null;

        return response()->view('checkout.thanks', compact('checkoutGoal'))
            ->header('Cache-Control', 'private, no-store')
            ->header('Referrer-Policy', 'no-referrer')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }

    public function openOrder(Request $request): RedirectResponse
    {
        return redirect()->to($this->sessionOrder($request)->customerUrl())
            ->header('Cache-Control', 'private, no-store')
            ->header('Referrer-Policy', 'no-referrer');
    }

    private function sessionOrder(Request $request): Order
    {
        return Order::query()->findOrFail($request->session()->get('checkout.completed_order_id'));
    }

    private function redirectToThanks(Request $request, Order $order): RedirectResponse
    {
        $request->session()->put('checkout.completed_order_id', $order->id);

        return to_route('checkout.thanks');
    }

    public function success(Order $order): Response
    {
        $order->load('items');

        return response()->view('checkout.success', [
            'order' => $order,
            'latestTerms' => $order->termsVersions()->first(),
            'acceptedTerms' => $order->termsVersions()->whereNotNull('accepted_at')->first(),
        ])
            ->header('Cache-Control', 'private, no-store')
            ->header('Referrer-Policy', 'no-referrer')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }

    public function acceptTerms(AcceptOrderTermsRequest $request, Order $order): RedirectResponse
    {
        app(OrderTerms::class)->accept($order, (int) $request->validated('version'));

        return redirect()->to($order->customerUrl())->with('success', 'Вы подтвердили предложенные условия заказа.')
            ->header('Cache-Control', 'private, no-store')
            ->header('Referrer-Policy', 'no-referrer');
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

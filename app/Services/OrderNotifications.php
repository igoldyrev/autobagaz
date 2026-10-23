<?php

namespace App\Services;

use App\Jobs\SendOrderNotification;
use App\Models\CallbackRequest;
use App\Models\Order;
use App\Models\OrderNotification;
use App\Models\OrderTermsVersion;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Throwable;

class OrderNotifications
{
    /** @return list<string> */
    public function managerRecipients(): array
    {
        $configured = config('orders.notification_emails');
        $recipients = array_values(array_unique(array_filter(array_map(
            fn (string $email) => strtolower(trim($email)),
            explode(',', $configured ?: (string) config('orders.notification_email')),
        ))));

        if ($recipients === [] || collect($recipients)->contains(fn (string $email) => ! filter_var($email, FILTER_VALIDATE_EMAIL))) {
            throw new InvalidArgumentException('Configure valid order notification recipients.');
        }

        return $recipients;
    }

    public function recordOrder(Order $order): void
    {
        foreach ($this->managerRecipients() as $recipient) {
            OrderNotification::query()->create(['order_id' => $order->id, 'type' => 'order_created', 'recipient' => $recipient]);
        }

        OrderNotification::query()->create(['order_id' => $order->id, 'type' => 'order_confirmation', 'recipient' => $order->email]);
    }

    public function recordCallback(CallbackRequest $callback): void
    {
        foreach ($this->managerRecipients() as $recipient) {
            OrderNotification::query()->create(['callback_request_id' => $callback->id, 'type' => 'callback_requested', 'recipient' => $recipient]);
        }
    }

    public function recordStatusChange(Order $order, string $previousStatus): ?OrderNotification
    {
        $type = OrderNotification::STATUS_TYPES[$order->status] ?? null;
        if ($type === null || $previousStatus === $order->status) {
            return null;
        }
        if (Validator::make(['email' => $order->email], ['email' => ['required', 'email:rfc']])->fails()) {
            Log::warning('Order event notification skipped: no valid customer email.', ['order_id' => $order->id, 'type' => $type]);

            return null;
        }

        $accepted = $order->termsVersions()->whereNotNull('accepted_at')->first();
        $latest = $order->termsVersions()->first();
        $deliveryMethod = $accepted?->delivery_method ?? $order->delivery_method;
        $terms = $accepted ? [
            'items' => $accepted->items, 'goods_total' => $accepted->goods_total, 'total' => $accepted->total,
            'delivery_method' => $accepted->delivery_method, 'delivery_address' => $accepted->delivery_address,
            'delivery_terms' => $accepted->delivery_terms, 'delivery_cost' => $accepted->delivery_cost,
            'payment_method' => $accepted->payment_method, 'payment_terms' => $accepted->payment_terms,
        ] : [
            'items' => $order->items()->orderBy('id')->get()->map(fn ($item) => [
                'product_name' => $item->product_name, 'unit_price' => $item->unit_price,
                'quantity' => $item->quantity, 'total' => $item->total, 'supply_terms' => null,
            ])->all(),
            'goods_total' => $order->total, 'total' => $deliveryMethod === 'pickup' ? $order->total : null,
            'delivery_method' => $deliveryMethod, 'delivery_address' => $order->delivery_address,
            'delivery_terms' => null, 'delivery_cost' => $deliveryMethod === 'pickup' ? '0.00' : null,
            'payment_method' => null, 'payment_terms' => null,
        ];
        $terms['payment_method_label'] = $accepted
            ? (OrderTermsVersion::paymentMethods()[$accepted->payment_method] ?? $accepted->payment_method)
            : null;

        return OrderNotification::query()->create([
            'order_id' => $order->id, 'type' => $type, 'recipient' => $order->email,
            'payload' => [
                'number' => $order->number, 'customer_name' => $order->customer_name,
                'occurred_at' => now()->toIso8601String(), 'terms_version' => $accepted?->version,
                'pending_terms_version' => $latest && ! $latest->accepted_at ? $latest->version : null,
                'terms' => $terms,
                'pickup_address' => $deliveryMethod === 'pickup' ? 'г. Пермь, ул. Дзержинского, 15' : null,
                'checkout_notices' => $accepted ? [] : ($order->checkout_terms['notices'] ?? []),
            ],
        ]);
    }

    public function dispatchPending(int $limit = 100, ?int $orderId = null, ?int $callbackId = null): int
    {
        try {
            $ids = OrderNotification::query()->whereNull('queued_at')->whereNull('sent_at')
                ->when($orderId, fn ($query) => $query->where('order_id', $orderId))
                ->when($callbackId, fn ($query) => $query->where('callback_request_id', $callbackId))
                ->orderBy('id')->limit($limit)->pluck('id');
        } catch (Throwable $exception) {
            Log::error('Pending order notifications could not be read.', ['exception_class' => $exception::class]);

            return 0;
        }
        $dispatched = 0;

        foreach ($ids as $id) {
            try {
                $dispatched += DB::transaction(function () use ($id): int {
                    $notification = OrderNotification::query()->lockForUpdate()->find($id);
                    if (! $notification || $notification->queued_at || $notification->sent_at) {
                        return 0;
                    }

                    $notification->update(['queued_at' => now()]);
                    Bus::dispatch((new SendOrderNotification($notification->id))->beforeCommit());

                    return 1;
                });
            } catch (Throwable $exception) {
                // Keep the durable notification pending; never fail an accepted checkout.
                Log::error('Order notification could not be queued.', [
                    'notification_id' => $id,
                    'exception_class' => $exception::class,
                ]);
            }
        }

        return $dispatched;
    }
}

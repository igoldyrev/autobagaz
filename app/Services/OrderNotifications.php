<?php

namespace App\Services;

use App\Jobs\SendOrderNotification;
use App\Models\CallbackRequest;
use App\Models\Order;
use App\Models\OrderNotification;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

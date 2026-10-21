<?php

namespace App\Jobs;

use App\Mail\CallbackRequested;
use App\Mail\OrderConfirmation;
use App\Mail\OrderCreated;
use App\Models\CallbackRequest;
use App\Models\Order;
use App\Models\OrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use LogicException;
use Throwable;

class SendOrderNotification implements ShouldQueue
{
    use Queueable;

    public int $tries = 5;

    public int $timeout = 60;

    public function __construct(public int $notificationId) {}

    /** @return list<int> */
    public function backoff(): array
    {
        return [60, 300, 900, 3600];
    }

    public function handle(): void
    {
        DB::transaction(function () {
            $notification = OrderNotification::query()->lockForUpdate()->find($this->notificationId);
            if (! $notification || $notification->sent_at) {
                return;
            }

            $mail = match ($notification->type) {
                'order_created' => new OrderCreated(Order::query()->findOrFail($notification->order_id)),
                'order_confirmation' => new OrderConfirmation(Order::query()->findOrFail($notification->order_id)),
                'callback_requested' => new CallbackRequested(CallbackRequest::query()->findOrFail($notification->callback_request_id)),
                default => throw new LogicException('Unknown order notification type.'),
            };

            Mail::to($notification->recipient)->sendNow($mail);
            $notification->update(['sent_at' => now(), 'failed_at' => null]);
        });
    }

    public function failed(?Throwable $exception): void
    {
        OrderNotification::query()->whereKey($this->notificationId)->whereNull('sent_at')->update(['failed_at' => now()]);
        Log::error('Order notification exhausted its attempts.', [
            'notification_id' => $this->notificationId,
            'exception_class' => $exception ? $exception::class : null,
        ]);
    }
}

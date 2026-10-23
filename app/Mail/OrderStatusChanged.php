<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use LogicException;

class OrderStatusChanged extends Mailable implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $event, public array $snapshot, public string $customerUrl) {}

    public function heading(): string
    {
        $label = match ($this->event) {
            'order_manager_confirmed' => 'подтверждён менеджером',
            'order_cancelled' => 'отменён',
            'order_ready' => $this->snapshot['terms']['delivery_method'] === 'delivery' ? 'готов к отправке' : 'готов к выдаче',
            'order_shipped' => 'отправлен',
            default => throw new LogicException('Unknown order status event.'),
        };

        return 'Заказ '.$this->snapshot['number'].' '.$label;
    }

    public function build(): self
    {
        return $this->subject($this->heading())->view('emails.orders.status-changed', ['heading' => $this->heading()]);
    }
}

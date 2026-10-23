<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderNotification extends Model
{
    public const STATUS_TYPES = [
        Order::STATUS_CONFIRMED => 'order_manager_confirmed',
        Order::STATUS_CANCELLED => 'order_cancelled',
        Order::STATUS_READY => 'order_ready',
        Order::STATUS_SHIPPED => 'order_shipped',
    ];

    protected $guarded = ['id'];

    protected $hidden = ['payload'];

    protected function casts(): array
    {
        return ['queued_at' => 'datetime', 'sent_at' => 'datetime', 'failed_at' => 'datetime', 'payload' => 'array'];
    }
}

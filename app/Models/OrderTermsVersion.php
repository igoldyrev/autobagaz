<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTermsVersion extends Model
{
    protected $guarded = ['id', 'accepted_at'];

    protected function casts(): array
    {
        return ['items' => 'array', 'goods_total' => 'decimal:2', 'delivery_cost' => 'decimal:2', 'total' => 'decimal:2', 'accepted_at' => 'datetime', 'version' => 'integer'];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public static function paymentMethods(): array
    {
        return ['cash' => 'Наличными', 'card' => 'Картой при получении', 'bank_transfer' => 'Банковским переводом', 'other' => 'Другой способ'];
    }
}

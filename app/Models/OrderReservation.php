<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderReservation extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['quantity' => 'integer', 'returned_quantity' => 'integer', 'expires_at' => 'datetime', 'released_at' => 'datetime'];
    }

    public function scopeLive(Builder $query): Builder
    {
        return $query->where(fn (Builder $q) => $q->where('state', 'paid')->orWhere(fn (Builder $q) => $q->where('state', 'active')->where('expires_at', '>', now())));
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stateLabel(): string
    {
        if ($this->state === 'active' && $this->expires_at->lessThanOrEqualTo(now())) {
            return 'Срок истёк';
        }

        return ['active' => 'Ожидает оплаты', 'paid' => 'Сохранён после оплаты', 'expired' => 'Срок истёк', 'released' => 'Освобождён', 'consumed' => 'Выдан / отправлен', 'returned' => 'Возвращён на склад'][$this->state] ?? $this->state;
    }
}

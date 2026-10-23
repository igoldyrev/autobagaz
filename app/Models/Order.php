<?php

namespace App\Models;

use App\Models\Concerns\HasProcessingWorkflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasProcessingWorkflow;

    public const STATUS_NEW = 'new';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_CONFIRMED = 'confirmed';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = ['consent_accepted_at', 'consent_version', 'consent_text', 'assignee_id', 'number', 'customer_name', 'phone', 'email', 'delivery_method', 'delivery_address', 'comment', 'status', 'total', 'checkout_token', 'vehicle_snapshot'];

    protected $hidden = ['access_token', 'checkout_token'];

    protected static function booted(): void
    {
        static::creating(function (Order $order): void {
            $order->access_token = bin2hex(random_bytes(32));
        });
    }

    public function customerUrl(): string
    {
        return route('checkout.success', ['order' => $this->access_token]);
    }

    protected function casts(): array
    {
        return ['consent_accepted_at' => 'datetime', 'total' => 'decimal:2', 'vehicle_snapshot' => 'array'];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /** @return array<string, string> */
    public static function statusLabels(): array
    {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_CONFIRMED => 'Подтверждён',
            self::STATUS_COMPLETED => 'Завершён',
            self::STATUS_CANCELLED => 'Отменён',
        ];
    }

    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    public function deliveryMethodLabel(): string
    {
        return $this->delivery_method === 'delivery' ? 'Доставка' : 'Самовывоз';
    }

    /** @return array<string, string> */
    protected function processingActions(): array
    {
        return [self::STATUS_CONFIRMED => 'Подтвердить заказ'];
    }

    protected function cancelActionLabel(): string
    {
        return 'Отменить заказ';
    }
}

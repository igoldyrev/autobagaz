<?php

namespace App\Models;

use App\Models\Concerns\HasProcessingWorkflow;
use App\Models\Concerns\HasResponseTracking;
use App\Services\OrderReservations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasProcessingWorkflow, HasResponseTracking;

    public const STATUS_NEW = 'new';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_CONFIRMED = 'confirmed';

    public const STATUS_AWAITING_SUPPLY = 'awaiting_supply';

    public const STATUS_READY = 'ready';

    public const STATUS_SHIPPED = 'shipped';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = ['consent_accepted_at', 'consent_version', 'consent_text', 'assignee_id', 'number', 'customer_name', 'phone', 'email', 'delivery_method', 'delivery_address', 'comment', 'status', 'total', 'checkout_token', 'vehicle_snapshot', 'checkout_terms'];

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
        return ['consent_accepted_at' => 'datetime', 'total' => 'decimal:2', 'vehicle_snapshot' => 'array', 'checkout_terms' => 'array', 'reservation_started_at' => 'datetime', 'reservation_expires_at' => 'datetime', 'paid_at' => 'datetime', 'paid_amount' => 'decimal:2'];
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(OrderReservation::class);
    }

    public function paymentLabel(): string
    {
        return ['unpaid' => 'Не оплачен', 'paid' => 'Оплачен', 'refunded' => 'Оплата возвращена'][$this->payment_status] ?? $this->payment_status;
    }

    public function reservationLabel(): string
    {
        if (! $this->reservation_started_at) {
            return 'Резерв не создавался';
        }
        $rows = $this->reservations;
        if ($rows->contains('state', 'paid')) {
            return 'Оплачен, резерв сохранён';
        }
        if ($rows->contains(fn ($row) => $row->state === 'active' && $row->expires_at->isFuture())) {
            return 'Резерв до '.$this->reservation_expires_at->timezone(config('app.display_timezone'))->format('d.m.Y H:i:s');
        }
        if ($rows->contains('state', 'consumed')) {
            return 'Товары списаны при выдаче / отправке';
        }
        if ($rows->contains('state', 'returned')) {
            return 'Товары возвращены на склад';
        }
        if ($rows->contains('state', 'released')) {
            return 'Резерв освобождён';
        }

        return $rows->isEmpty() ? 'Под заказ — без складского резерва' : 'Срок резерва истёк';
    }

    public function canCollect(): bool
    {
        return app(OrderReservations::class)->canCollect($this);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function termsVersions(): HasMany
    {
        return $this->hasMany(OrderTermsVersion::class)->orderByDesc('version');
    }

    /** @return array<string, string> */
    public static function statusLabels(): array
    {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_CONFIRMED => 'Подтверждён менеджером',
            self::STATUS_AWAITING_SUPPLY => 'Ожидает поставки',
            self::STATUS_READY => 'Готов к выдаче / отправке',
            self::STATUS_SHIPPED => 'Отправлен',
            self::STATUS_COMPLETED => 'Завершён',
            self::STATUS_CANCELLED => 'Отменён',
        ];
    }

    public function statusLabel(): string
    {
        if ($this->status === self::STATUS_READY) {
            return $this->effectiveDeliveryMethod() === 'delivery' ? 'Готов к отправке' : 'Готов к выдаче';
        }

        return self::statusLabels()[$this->status] ?? $this->status;
    }

    public function deliveryMethodLabel(): string
    {
        return $this->delivery_method === 'delivery' ? 'Доставка' : 'Самовывоз';
    }

    public function latestTermsVersion(): HasOne
    {
        return $this->hasOne(OrderTermsVersion::class)->latestOfMany('version');
    }

    public function acceptedTermsVersion(): HasOne
    {
        return $this->hasOne(OrderTermsVersion::class)->ofMany(['version' => 'max'], function (Builder $query): void {
            $query->whereNotNull('accepted_at');
        });
    }

    public function effectiveDeliveryMethod(): string
    {
        return $this->acceptedTermsVersion?->delivery_method ?? $this->delivery_method;
    }

    public function effectiveDeliveryMethodLabel(): string
    {
        return $this->effectiveDeliveryMethod() === 'delivery' ? 'Доставка' : 'Самовывоз';
    }

    public function canEditTerms(): bool
    {
        return in_array($this->status, [self::STATUS_NEW, self::STATUS_IN_PROGRESS, self::STATUS_CONFIRMED, self::STATUS_AWAITING_SUPPLY], true);
    }

    public function availableActions(): array
    {
        $latest = $this->latestTermsVersion;
        $agreed = $latest === null || $latest->accepted_at !== null;
        $cancel = [self::STATUS_CANCELLED => $this->cancelActionLabel()];
        $back = [self::STATUS_IN_PROGRESS => 'Вернуть к согласованию'];

        $actions = match ($this->status) {
            self::STATUS_NEW => [self::STATUS_IN_PROGRESS => $this->assignee_id ? 'Начать обработку' : 'Взять в работу'] + $cancel,
            self::STATUS_IN_PROGRESS => $this->processingActions() + $cancel,
            self::STATUS_CONFIRMED => [self::STATUS_AWAITING_SUPPLY => 'Ожидать поставку']
                + ($agreed ? [self::STATUS_READY => 'Весь заказ собран'] : []) + $back + $cancel,
            self::STATUS_AWAITING_SUPPLY => ($agreed ? [self::STATUS_READY => 'Весь заказ собран'] : []) + $back + $cancel,
            self::STATUS_READY => ($agreed ? ($this->effectiveDeliveryMethod() === 'delivery'
                ? [self::STATUS_SHIPPED => 'Передан службе доставки']
                : [self::STATUS_COMPLETED => 'Завершить заказ']) : []) + $back + $cancel,
            self::STATUS_SHIPPED => $agreed ? [self::STATUS_COMPLETED => 'Завершить заказ'] : [],
            default => [],
        };

        if ($this->reservation_started_at && $this->canCollect() && $this->effectiveDeliveryMethod() === 'pickup' && ! $this->isClosed()) {
            $actions = [self::STATUS_COMPLETED => 'Выдать оплаченный заказ'] + $actions;
        }

        return $actions;
    }

    public function processingSteps(): array
    {
        $steps = self::statusLabels();
        unset($steps[self::STATUS_CANCELLED]);
        $steps[self::STATUS_READY] = $this->effectiveDeliveryMethod() === 'delivery' ? 'Готов к отправке' : 'Готов к выдаче';
        if ($this->effectiveDeliveryMethod() !== 'delivery') {
            unset($steps[self::STATUS_SHIPPED]);
        }

        return $steps;
    }

    public function statusDescription(): string
    {
        if ($this->canCollect()) {
            return $this->effectiveDeliveryMethod() === 'pickup'
                ? 'Оплата подтверждена. Товары в наличии, ожидать подтверждения менеджера для самовывоза не нужно.'
                : 'Оплата подтверждена. Товары зарезервированы, менеджер оформляет отправку.';
        }

        return match ($this->status) {
            self::STATUS_NEW => 'Заявка получена и ожидает обработки менеджером.',
            self::STATUS_IN_PROGRESS => 'Менеджер проверяет товары и согласует условия заказа.',
            self::STATUS_CONFIRMED => 'Менеджер подтвердил возможность выполнения заказа. Согласование условий учитывается отдельно.',
            self::STATUS_AWAITING_SUPPLY => 'Ожидаем поступления товаров, чтобы собрать весь заказ.',
            self::STATUS_READY => $this->effectiveDeliveryMethod() === 'delivery'
                ? 'Весь заказ собран и готов к передаче службе доставки.'
                : 'Весь заказ готов к получению в магазине. Если согласована установка, она выполняется по записи.',
            self::STATUS_SHIPPED => 'Заказ передан службе доставки. Ожидаем получения покупателем.',
            self::STATUS_COMPLETED => 'Покупатель получил заказ или установка в магазине завершена.',
            self::STATUS_CANCELLED => 'Выполнение заказа прекращено. Расчёты по оплате и возвратам учитываются отдельно.',
            default => '',
        };
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

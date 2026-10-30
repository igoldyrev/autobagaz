<?php

namespace App\Models;

use App\Models\Concerns\HasResponseTracking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalRequest extends Model
{
    use HasResponseTracking;

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        $casts = ['version' => 'integer', 'quantity' => 'integer', 'original_request' => 'array', 'starts_on' => 'date', 'ends_on' => 'date'];
        foreach (['daily_price', 'rental_total', 'rental_paid', 'buyout_price', 'deposit_required', 'deposit_received', 'deposit_returned', 'deposit_withheld', 'deposit_applied', 'buyout_paid'] as $field) {
            $casts[$field] = 'decimal:2';
        }
        foreach (['issued_at', 'returned_at', 'purchased_at', 'deposit_received_at', 'deposit_returned_at', 'consent_accepted_at'] as $field) {
            $casts[$field] = 'datetime';
        }

        return $casts;
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public static function statusLabels(): array
    {
        return ['new' => 'Новая', 'in_progress' => 'В работе', 'confirmed' => 'Подтверждена', 'rented' => 'В прокате', 'returned' => 'Возвращено', 'completed' => 'Завершена', 'purchased' => 'Выкуплено', 'cancelled' => 'Отменена'];
    }

    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status];
    }

    public function isClosed(): bool
    {
        return in_array($this->status, ['completed', 'purchased', 'cancelled'], true);
    }

    public function isOverdue(): bool
    {
        return $this->status === 'rented' && $this->ends_on->toDateString() < now(config('app.display_timezone'))->toDateString();
    }

    public function scopeResponseState(Builder $query, ?string $state): Builder
    {
        if ($state === 'answered') {
            return $query->whereNotNull('first_response_at');
        }
        if (in_array($state, ['waiting', 'overdue'], true)) {
            $query->whereNull('first_response_at')->whereNotIn('status', ['completed', 'purchased', 'cancelled']);
            if ($state === 'overdue') {
                $query->where('response_due_at', '<', now());
            }
        }

        return $query;
    }

    public function availableActions(): array
    {
        return match ($this->status) {
            'new' => ['start' => 'Взять в работу', 'cancel' => 'Отменить заявку'],
            'in_progress' => ['confirm' => 'Подтвердить', 'cancel' => 'Отменить заявку'],
            'confirmed' => ['revise' => 'Вернуть к согласованию', 'issue' => 'Выдать оборудование', 'cancel' => 'Отменить заявку'],
            'rented' => ['return_equipment' => 'Принять оборудование', 'purchase' => 'Оформить выкуп'],
            'returned' => ['complete' => 'Завершить прокат'],
            default => [],
        };
    }

    public function depositBalance(): int
    {
        return self::cents($this->deposit_received) - self::cents($this->deposit_returned) - self::cents($this->deposit_withheld) - self::cents($this->deposit_applied);
    }

    public function depositSettled(): bool
    {
        return $this->deposit_type === 'document'
            ? ! $this->deposit_received_at || $this->deposit_returned_at !== null
            : $this->depositBalance() === 0;
    }

    public function depositLabel(): string
    {
        if (! $this->deposit_received_at) {
            return 'Не получен';
        }
        if ($this->deposit_type === 'document') {
            return $this->deposit_returned_at ? 'Документ возвращён' : 'Документ получен';
        }

        return $this->depositBalance() > 0 ? 'Денежный залог: остаток '.number_format($this->depositBalance() / 100, 2, ',', ' ').' ₽' : 'Расчёты по залогу закрыты';
    }

    public static function cents(string|int|float $value): int
    {
        return (int) round((float) $value * 100);
    }
}

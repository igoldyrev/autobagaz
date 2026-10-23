<?php

namespace App\Models\Concerns;

use App\Services\OrderResponseTime;
use Illuminate\Database\Eloquent\Builder;

trait HasResponseTracking
{
    public function initializeHasResponseTracking(): void
    {
        $this->mergeCasts(['response_due_at' => 'datetime', 'first_response_at' => 'datetime', 'response_stopped_at' => 'datetime']);
        $this->makeHidden(['response_due_at', 'first_response_at', 'first_response_by', 'first_response_by_name', 'response_stopped_at']);
    }

    public static function bootHasResponseTracking(): void
    {
        static::creating(function ($record): void {
            $record->response_due_at = app(OrderResponseTime::class)->deadline($record->created_at ?? now());
            if ($record->isClosed()) {
                $record->response_stopped_at = $record->created_at ?? now();
            }
        });
    }

    public function responseWasLate(): bool
    {
        $end = $this->first_response_at ?? $this->response_stopped_at ?? now();

        return $this->response_due_at !== null && $end->greaterThan($this->response_due_at);
    }

    public function responseDelayMinutes(): int
    {
        return $this->responseWasLate()
            ? app(OrderResponseTime::class)->workingMinutesBetween($this->response_due_at, $this->first_response_at ?? $this->response_stopped_at ?? now())
            : 0;
    }

    public function scopeResponseState(Builder $query, ?string $state): Builder
    {
        if ($state === 'answered') {
            return $query->whereNotNull('first_response_at');
        }
        if (in_array($state, ['waiting', 'overdue'], true)) {
            $query->whereNull('first_response_at')->whereNotIn('status', [self::STATUS_COMPLETED, self::STATUS_CANCELLED]);
            if ($state === 'overdue') {
                $query->where('response_due_at', '<', now());
            }
        }

        return $query;
    }
}

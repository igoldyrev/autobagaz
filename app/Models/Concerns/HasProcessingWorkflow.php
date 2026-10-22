<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasProcessingWorkflow
{
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /** @return array<string, string> */
    public function availableActions(): array
    {
        return match ($this->status) {
            self::STATUS_NEW => [self::STATUS_IN_PROGRESS => 'Взять в работу', self::STATUS_CANCELLED => $this->cancelActionLabel()],
            self::STATUS_IN_PROGRESS => $this->processingActions() + [self::STATUS_CANCELLED => $this->cancelActionLabel()],
            'confirmed' => [self::STATUS_COMPLETED => 'Завершить заказ', self::STATUS_CANCELLED => $this->cancelActionLabel()],
            default => [],
        };
    }

    public function isClosed(): bool
    {
        return in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_CANCELLED], true);
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\HasProcessingWorkflow;
use Illuminate\Database\Eloquent\Model;

class CallbackRequest extends Model
{
    use HasProcessingWorkflow;

    public const STATUS_NEW = 'new';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = ['assignee_id', 'name', 'phone', 'status'];

    /** @return array<string, string> */
    public static function statusLabels(): array
    {
        return [
            self::STATUS_NEW => 'Новая',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETED => 'Завершена',
            self::STATUS_CANCELLED => 'Отменена',
        ];
    }

    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    /** @return array<string, string> */
    protected function processingActions(): array
    {
        return [self::STATUS_COMPLETED => 'Завершить'];
    }

    protected function cancelActionLabel(): string
    {
        return 'Отменить заявку';
    }
}

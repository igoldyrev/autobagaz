<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminActivityLog extends Model
{
    public const UPDATED_AT = null;

    public const ACTION_CREATED = 'created';

    public const ACTION_UPDATED = 'updated';

    public const ACTION_DELETED = 'deleted';

    public const ACTION_LOGIN = 'login';

    public const ACTION_LOGOUT = 'logout';

    public const ACTION_SESSIONS_TERMINATED = 'sessions_terminated';

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'subject_type',
        'subject_id',
        'subject_name',
        'description',
    ];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return array<string, string> */
    public static function actionLabels(): array
    {
        return [
            self::ACTION_CREATED => 'Добавление',
            self::ACTION_UPDATED => 'Изменение',
            self::ACTION_DELETED => 'Удаление',
            self::ACTION_LOGIN => 'Вход',
            self::ACTION_LOGOUT => 'Выход',
            self::ACTION_SESSIONS_TERMINATED => 'Завершение сеансов',
        ];
    }

    public function actionLabel(): string
    {
        return self::actionLabels()[$this->action] ?? $this->action;
    }

    public function scopeOlderThanRetentionPeriod(Builder $query): Builder
    {
        return $query->where('created_at', '<', now()->subDays(180));
    }
}

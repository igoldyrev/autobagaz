<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\CallbackRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\VehicleConfiguration;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

class AdminMonitoringReport
{
    public const SCHEMA_VERSION = '1.0';

    public const SOURCE = 'autobagaz';

    /** @var list<string> */
    private const CHANGE_ACTIONS = [
        AdminActivityLog::ACTION_CREATED,
        AdminActivityLog::ACTION_UPDATED,
        AdminActivityLog::ACTION_DELETED,
        AdminActivityLog::ACTION_SESSIONS_TERMINATED,
    ];

    /** @var array<string, string> */
    private const SAFE_SUBJECT_TYPES = [
        'roof_rack_manufacturer' => 'Производитель автобагажников',
        'auto_box_manufacturer' => 'Производитель автобоксов',
        'roof_rack' => 'Автобагажник',
        'auto_box' => 'Автобокс',
        'catalog_category' => 'Категория',
        'user' => 'Администратор',
        'vehicle_make' => 'Марка автомобиля',
        'vehicle_model' => 'Модель автомобиля',
        'vehicle_generation' => 'Поколение автомобиля',
        'vehicle_configuration' => 'Конфигурация автомобиля',
        'vehicle_body_style' => 'Тип кузова',
        'vehicle_roof_type' => 'Тип крыши',
        'fitment' => 'Группа применяемости',
        'compatibility_override' => 'Правило совместимости',
    ];

    /** @return array<string, mixed> */
    public function build(?string $date = null, int $changesLimit = 3): array
    {
        $timezone = config('app.display_timezone');
        $targetDate = $this->targetDate($date, $timezone);
        $start = $targetDate->startOfDay();
        $end = $targetDate->endOfDay();
        $changesLimit = min(max($changesLimit, 1), 10);

        $administrators = $this->administrators($start, $end, $changesLimit);

        return [
            'schema_version' => self::SCHEMA_VERSION,
            'source' => self::SOURCE,
            'state' => 'ok',
            'generated_at' => CarbonImmutable::now($timezone)->toIso8601String(),
            'period' => [
                'date' => $targetDate->toDateString(),
                'timezone' => $timezone,
                'starts_at' => $start->toIso8601String(),
                'ends_at' => $end->toIso8601String(),
            ],
            'site' => [
                'available' => true,
                'database' => 'ok',
            ],
            'orders' => $this->orders($start, $end),
            'callback_requests' => $this->callbackRequests(),
            'products' => $this->products(),
            'vehicle_configurations' => $this->vehicleConfigurations(),
            'administrators' => $administrators,
            'activity' => $this->activity($start, $end, $changesLimit),
        ];
    }

    /** @return list<array<string, mixed>> */
    private function administrators(CarbonImmutable $start, CarbonImmutable $end, int $changesLimit): array
    {
        return User::query()
            ->where('is_admin', true)
            ->orderByRaw('last_seen_at IS NULL')
            ->orderByDesc('last_seen_at')
            ->orderBy('name')
            ->get(['id', 'name', 'role', 'last_login_at', 'last_seen_at'])
            ->map(function (User $administrator) use ($start, $end, $changesLimit): array {
                $changes = $this->changesQuery()
                    ->where('user_id', $administrator->id)
                    ->whereBetween('created_at', [$start->utc(), $end->utc()]);

                return [
                    'id' => $administrator->id,
                    'name' => $administrator->name,
                    'role' => $administrator->role ?: User::ROLE_ADMINISTRATOR,
                    'role_label' => $administrator->role
                        ? $administrator->roleLabel()
                        : User::roleLabels()[User::ROLE_ADMINISTRATOR],
                    'last_login_at' => $this->timestamp($administrator->last_login_at),
                    'last_seen_at' => $this->timestamp($administrator->last_seen_at),
                    'changes_count' => (clone $changes)->count(),
                    'changes' => (clone $changes)
                        ->latest('created_at')
                        ->latest('id')
                        ->limit($changesLimit)
                        ->get(['action', 'subject_type', 'subject_name', 'created_at'])
                        ->map(fn (AdminActivityLog $activity): array => $this->changePayload($activity))
                        ->all(),
                ];
            })
            ->all();
    }

    /** @return array<string, mixed> */
    private function orders(CarbonImmutable $start, CarbonImmutable $end): array
    {
        $statistics = Order::query()
            ->selectRaw('status, COUNT(*) as aggregate_count, COALESCE(SUM(total), 0) as aggregate_amount')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $byStatus = collect(Order::statusLabels())
            ->mapWithKeys(function (string $label, string $status) use ($statistics): array {
                $row = $statistics->get($status);

                return [$status => [
                    'label' => $label,
                    'count' => (int) ($row?->aggregate_count ?? 0),
                    'amount' => $this->money($row?->aggregate_amount),
                ]];
            })
            ->all();

        $createdForDay = Order::query()
            ->whereBetween('created_at', [$start->utc(), $end->utc()])
            ->selectRaw('COUNT(*) as aggregate_count, COALESCE(SUM(total), 0) as aggregate_amount')
            ->first();

        return [
            'by_status' => $byStatus,
            'created_for_day' => [
                'count' => (int) ($createdForDay?->aggregate_count ?? 0),
                'amount' => $this->money($createdForDay?->aggregate_amount),
            ],
            'awaiting_processing' => $byStatus[Order::STATUS_NEW]['count'],
        ];
    }

    /** @return array{new: int, unclosed: int} */
    private function callbackRequests(): array
    {
        return [
            'new' => CallbackRequest::query()->where('status', CallbackRequest::STATUS_NEW)->count(),
            'unclosed' => CallbackRequest::query()->whereIn('status', [
                CallbackRequest::STATUS_NEW,
                CallbackRequest::STATUS_IN_PROGRESS,
            ])->count(),
        ];
    }

    /** @return array<string, int> */
    private function products(): array
    {
        $counts = Product::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as published')
            ->selectRaw('SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as hidden')
            ->first();

        return [
            'total' => (int) ($counts?->total ?? 0),
            'published' => (int) ($counts?->published ?? 0),
            'hidden' => (int) ($counts?->hidden ?? 0),
            'without_images' => Product::query()->doesntHave('images')->count(),
            'published_roof_racks_without_fitments' => Product::query()
                ->whereHas('roofRack')
                ->where('is_active', true)
                ->whereDoesntHave('fitments', fn (Builder $query) => $query
                    ->active()
                    ->where('fitment_product.status', 'active'))
                ->count(),
        ];
    }

    /** @return array{without_compatibility: int} */
    private function vehicleConfigurations(): array
    {
        return [
            'without_compatibility' => VehicleConfiguration::query()
                ->whereDoesntHave('fitments', fn (Builder $query) => $query->active())
                ->count(),
        ];
    }

    /** @return array<string, mixed> */
    private function activity(CarbonImmutable $start, CarbonImmutable $end, int $changesLimit): array
    {
        $changes = $this->changesQuery()
            ->whereBetween('created_at', [$start->utc(), $end->utc()]);

        return [
            'changes_for_day' => (clone $changes)->count(),
            'recent_changes' => (clone $changes)
                ->latest('created_at')
                ->latest('id')
                ->limit($changesLimit)
                ->get(['user_id', 'user_name', 'action', 'subject_type', 'subject_name', 'created_at'])
                ->map(fn (AdminActivityLog $activity): array => [
                    'administrator' => [
                        'id' => $activity->user_id,
                        'name' => $activity->user_name,
                    ],
                    ...$this->changePayload($activity),
                ])
                ->all(),
        ];
    }

    private function changesQuery(): Builder
    {
        return AdminActivityLog::query()
            ->whereIn('action', self::CHANGE_ACTIONS)
            ->where(function (Builder $query): void {
                $query->whereIn('subject_type', array_keys(self::SAFE_SUBJECT_TYPES))
                    ->orWhere(function (Builder $query): void {
                        $query->whereNull('subject_type')
                            ->where('action', AdminActivityLog::ACTION_SESSIONS_TERMINATED);
                    });
            });
    }

    /** @return array{action: string, description: string, subject_type: string|null, subject_name: string|null, occurred_at: string|null} */
    private function changePayload(AdminActivityLog $activity): array
    {
        $subjectLabel = self::SAFE_SUBJECT_TYPES[$activity->subject_type] ?? null;
        $description = match ($activity->action) {
            AdminActivityLog::ACTION_CREATED => 'Добавлен',
            AdminActivityLog::ACTION_UPDATED => 'Изменён',
            AdminActivityLog::ACTION_DELETED => 'Удалён',
            AdminActivityLog::ACTION_SESSIONS_TERMINATED => 'Завершены сеансы администратора',
            default => 'Изменён объект',
        };

        if ($activity->action !== AdminActivityLog::ACTION_SESSIONS_TERMINATED && $subjectLabel !== null) {
            $description .= ': '.$subjectLabel;
            if (filled($activity->subject_name)) {
                $description .= ' «'.$activity->subject_name.'»';
            }
        }

        return [
            'action' => $activity->action,
            'description' => $description,
            'subject_type' => $activity->subject_type,
            'subject_name' => $activity->subject_name,
            'occurred_at' => $this->timestamp($activity->created_at),
        ];
    }

    private function money(mixed $amount): string
    {
        return number_format((float) ($amount ?? 0), 2, '.', '');
    }

    private function targetDate(?string $date, string $timezone): CarbonImmutable
    {
        if ($date === null) {
            return CarbonImmutable::now($timezone);
        }

        $parsed = CarbonImmutable::createFromFormat('!Y-m-d', $date, $timezone);
        if ($parsed === false || $parsed->toDateString() !== $date) {
            throw new InvalidArgumentException('Date must use YYYY-MM-DD format.');
        }

        return $parsed;
    }

    private function timestamp(?CarbonInterface $timestamp): ?string
    {
        return $timestamp?->toImmutable()->utc()->toIso8601String();
    }
}

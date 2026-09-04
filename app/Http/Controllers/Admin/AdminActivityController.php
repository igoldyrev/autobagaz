<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminActivityController extends Controller
{
    /** @var array<string, string> */
    private const SUBJECT_LABELS = [
        'roof_rack' => 'Автобагажники',
        'auto_box' => 'Автомобильные боксы',
        'roof_rack_manufacturer' => 'Производители багажников',
        'auto_box_manufacturer' => 'Производители боксов',
        'catalog_category' => 'Разделы и категории',
        'vehicle_make' => 'Марки автомобилей',
        'vehicle_model' => 'Модели автомобилей',
        'vehicle_generation' => 'Поколения автомобилей',
        'vehicle_configuration' => 'Конфигурации автомобилей',
        'vehicle_body_style' => 'Типы кузова',
        'vehicle_roof_type' => 'Типы крыши',
        'fitment' => 'Группы применяемости',
        'compatibility_override' => 'Ручные исключения',
        'user' => 'Пользователи и профиль',
    ];

    public function __invoke(Request $request): View
    {
        $filters = $request->validate([
            'user_id' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'action' => ['nullable', Rule::in(array_keys(AdminActivityLog::actionLabels()))],
            'subject_type' => ['nullable', Rule::in(array_keys(self::SUBJECT_LABELS))],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
        ]);

        $activities = AdminActivityLog::query()
            ->with('user')
            ->when(filled($filters['user_id'] ?? null), fn ($query) => $query->where('user_id', (int) $filters['user_id']))
            ->when(filled($filters['action'] ?? null), fn ($query) => $query->where('action', $filters['action']))
            ->when(filled($filters['subject_type'] ?? null), fn ($query) => $query->where('subject_type', $filters['subject_type']))
            ->when(filled($filters['date_from'] ?? null), fn ($query) => $query->whereDate('created_at', '>=', $filters['date_from']))
            ->when(filled($filters['date_to'] ?? null), fn ($query) => $query->whereDate('created_at', '<=', $filters['date_to']))
            ->latest('created_at')
            ->latest('id')
            ->paginate(50)
            ->withQueryString();

        return view('admin.activity.index', [
            'activities' => $activities,
            'users' => User::query()->where('is_admin', true)->orderBy('name')->get(['id', 'name']),
            'actionLabels' => AdminActivityLog::actionLabels(),
            'subjectLabels' => self::SUBJECT_LABELS,
        ]);
    }
}

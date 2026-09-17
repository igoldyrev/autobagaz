<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompatibilityOverride;
use App\Models\Fitment;
use App\Models\Product;
use App\Models\VehicleConfiguration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class CompatibilityQualityController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.compatibility-quality.index', [
            'metrics' => [
                [
                    'count' => Product::query()->whereHas('roofRack')->where('is_active', true)
                        ->whereDoesntHave('fitments', fn ($query) => $query->active()->where('fitment_product.status', 'active'))->count(),
                    'label' => 'опубликованных автобагажников без применяемости',
                    'description' => 'Товар не будет показан как подходящий при подборе по автомобилю.',
                    'url' => route('admin.products.roof-racks.index', ['quality' => 'without_fitments']),
                    'level' => 'critical',
                ],
                [
                    'count' => VehicleConfiguration::query()->whereDoesntHave('fitments', fn ($query) => $query->active())->count(),
                    'label' => 'конфигураций без применяемости',
                    'description' => 'Для автомобиля не настроена ни одна активная группа.',
                    'url' => route('admin.vehicles.configurations.quality'),
                    'level' => 'critical',
                ],
                [
                    'count' => Fitment::query()->active()->doesntHave('configurations')->count(),
                    'label' => 'активных групп без автомобилей',
                    'description' => 'Группа не влияет на подбор, пока в ней нет конфигураций.',
                    'url' => route('admin.fitments.index', ['quality' => 'no_configurations']),
                    'level' => 'critical',
                ],
                [
                    'count' => Fitment::query()->active()->doesntHave('products')->count(),
                    'label' => 'активных групп без товаров',
                    'description' => 'Настройка автомобилей не даёт результата без привязанного товара.',
                    'url' => route('admin.fitments.index', ['quality' => 'no_products']),
                    'level' => 'warning',
                ],
                [
                    'count' => Fitment::query()->where('verification_status', 'needs_review')->count(),
                    'label' => 'групп, требующих проверки',
                    'description' => 'Данные ещё не подтверждены источником или реальной установкой.',
                    'url' => route('admin.fitments.index', ['verification_status' => 'needs_review']),
                    'level' => 'warning',
                ],
                [
                    'count' => $this->conflictGroups()->get()->count(),
                    'label' => 'конфликтов ручных исключений',
                    'description' => 'Одновременно действуют противоположные правила с одинаковым приоритетом.',
                    'url' => route('admin.compatibility-overrides.index', ['quality' => 'conflicts']),
                    'level' => 'critical',
                ],
            ],
        ]);
    }

    private function conflictGroups(): Builder
    {
        return CompatibilityOverride::query()->effective()
            ->selectRaw('MIN(id)')
            ->groupBy(['vehicle_configuration_id', 'fitment_id', 'base_product_id', 'accessory_product_id', 'priority'])
            ->havingRaw('COUNT(DISTINCT status) > 1');
    }
}

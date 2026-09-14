<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Product;
use App\Models\User;
use App\Models\VehicleConfiguration;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        /** @var User $user */
        $user = auth()->user();
        $canManageProducts = $user->hasPermission(User::PERMISSION_PRODUCTS);
        $canManageVehicles = $user->hasPermission(User::PERMISSION_VEHICLES);

        $attentionItems = [];

        if ($canManageProducts) {
            $productsWithoutImages = Product::query()->doesntHave('images')->count();
            $inactiveProducts = Product::query()->where('is_active', false)->count();
            $roofRacksWithoutFitments = Product::query()
                ->whereHas('roofRack')
                ->doesntHave('fitments')
                ->count();

            if ($productsWithoutImages > 0) {
                $attentionItems[] = [
                    'count' => $productsWithoutImages,
                    'label' => 'товаров без фотографий',
                    'url' => route('admin.products.index'),
                ];
            }

            if ($inactiveProducts > 0) {
                $attentionItems[] = [
                    'count' => $inactiveProducts,
                    'label' => 'товаров скрыты с сайта',
                    'url' => route('admin.products.index'),
                ];
            }

            if ($roofRacksWithoutFitments > 0) {
                $attentionItems[] = [
                    'count' => $roofRacksWithoutFitments,
                    'label' => 'автобагажников без применяемости',
                    'url' => route('admin.fitments.index'),
                ];
            }
        }

        if ($canManageVehicles) {
            $configurationsWithoutFitments = VehicleConfiguration::query()->doesntHave('fitments')->count();

            if ($configurationsWithoutFitments > 0) {
                $attentionItems[] = [
                    'count' => $configurationsWithoutFitments,
                    'label' => 'конфигураций без совместимости',
                    'url' => route('admin.vehicles.vehicle-makes.index'),
                ];
            }
        }

        return view('admin.dashboard', [
            'productStatistics' => $canManageProducts ? [
                $this->productStatistic('roofRack', 'Автобагажники', 'admin.products.roof-racks.index'),
                $this->productStatistic('autoBox', 'Автомобильные боксы', 'admin.products.auto-boxes.index'),
                $this->productStatistic('bikeRack', 'Велокрепления', 'admin.products.bike-racks.index'),
                $this->productStatistic('skiRack', 'Лыжные крепления', 'admin.products.ski-racks.index'),
            ] : [],
            'attentionItems' => $attentionItems,
            'canManageProducts' => $canManageProducts,
            'canManageVehicles' => $canManageVehicles,
            'recentActivities' => $user->isSuperAdmin()
                ? AdminActivityLog::query()->latest('created_at')->latest('id')->limit(5)->get()
                : collect(),
        ]);
    }

    /** @return array{label: string, total: int, active: int, url: string} */
    private function productStatistic(string $relation, string $label, string $routeName): array
    {
        $query = Product::query()->whereHas($relation);

        return [
            'label' => $label,
            'total' => (clone $query)->count(),
            'active' => (clone $query)->where('is_active', true)->count(),
            'url' => route($routeName),
        ];
    }
}

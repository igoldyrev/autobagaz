<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\CallbackRequest;
use App\Models\Order;
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
        $canManageOrders = $user->hasPermission(User::PERMISSION_ORDERS);

        $attentionItems = [];

        if ($canManageProducts) {
            $productsWithoutImages = Product::query()->doesntHave('images')->count();
            $inactiveProducts = Product::query()->where('is_active', false)->count();
            $roofRacksWithoutFitments = Product::query()
                ->whereHas('roofRack')
                ->where('is_active', true)
                ->whereDoesntHave('fitments', fn ($query) => $query->active()->where('fitment_product.status', 'active'))
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
                    'label' => 'опубликованных автобагажников без применяемости',
                    'url' => route('admin.products.roof-racks.index', ['quality' => 'without_fitments']),
                ];
            }
        }

        if ($canManageVehicles) {
            $configurationsWithoutFitments = VehicleConfiguration::query()->whereDoesntHave('fitments', fn ($query) => $query->active())->count();

            if ($configurationsWithoutFitments > 0) {
                $attentionItems[] = [
                    'count' => $configurationsWithoutFitments,
                    'label' => 'конфигураций без совместимости',
                    'url' => route('admin.vehicles.configurations.quality'),
                ];
            }
        }

        if ($canManageOrders) {
            $newOrders = Order::query()->where('status', Order::STATUS_NEW)->count();
            $newCallbackRequests = CallbackRequest::query()->where('status', CallbackRequest::STATUS_NEW)->count();
            if ($newOrders > 0) {
                $attentionItems[] = [
                    'count' => $newOrders,
                    'label' => 'новых заказов ждут обработки',
                    'url' => route('admin.orders.index', ['status' => Order::STATUS_NEW]),
                ];
            }

            if ($newCallbackRequests > 0) {
                $attentionItems[] = [
                    'count' => $newCallbackRequests,
                    'label' => 'новых заявок на обратный звонок',
                    'url' => route('admin.callback-requests.index', ['status' => CallbackRequest::STATUS_NEW]),
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
            'orderStatistics' => $canManageOrders ? collect(Order::statusLabels())
                ->map(fn (string $label, string $status) => $this->orderStatistic($status, $label))
                ->values() : [],
            'attentionItems' => $attentionItems,
            'canManageProducts' => $canManageProducts,
            'canManageVehicles' => $canManageVehicles,
            'canManageOrders' => $canManageOrders,
            'recentActivities' => AdminActivityLog::query()->latest('created_at')->latest('id')->limit(5)->get(),
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

    /** @return array{label: string, total: int, amount: float, url: string} */
    private function orderStatistic(string $status, string $label): array
    {
        $query = Order::query()->where('status', $status);

        return [
            'label' => $label,
            'total' => (clone $query)->count(),
            'amount' => (float) (clone $query)->sum('total'),
            'url' => route('admin.orders.index', ['status' => $status]),
        ];
    }
}

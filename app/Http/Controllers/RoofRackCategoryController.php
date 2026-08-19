<?php

namespace App\Http\Controllers;

use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\VehicleMake;
use App\Services\CatalogProductFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class RoofRackCategoryController extends Controller
{
    public function index(): View
    {
        $rootCategory = $this->rootCategory();
        $specialCategories = $rootCategory->children()
            ->active()
            ->where('kind', 'special')
            ->get();
        $vehicleMakes = $rootCategory->vehicleMakes()
            ->active()
            ->orderByPivot('sort_order')
            ->orderBy('name')
            ->get();

        $categories = $specialCategories
            ->concat($vehicleMakes)
            ->sortBy(fn (CatalogCategory|VehicleMake $category): int => $category instanceof VehicleMake
                ? $category->pivot->sort_order
                : $category->sort_order)
            ->values();

        return view('catalog.categories.index', compact('rootCategory', 'categories'));
    }

    public function show(Request $request, string $category, CatalogProductFilter $productFilter): View
    {
        $rootCategory = $this->rootCategory();
        $currentCategory = $rootCategory->vehicleMakes()
            ->active()
            ->where('slug', $category)
            ->first();

        if ($currentCategory) {
            $models = $currentCategory->models()->active()->get();
            $productQuery = Product::query()
                ->active()
                ->where(function (Builder $query) use ($currentCategory): void {
                    $query->whereHas('vehicleModels', fn (Builder $models) => $models
                        ->active()
                        ->where('vehicle_make_id', $currentCategory->id))
                        ->orWhereHas('vehicleBodyTypes', fn (Builder $bodyTypes) => $bodyTypes
                            ->active()
                            ->whereHas('vehicleModel', fn (Builder $models) => $models
                                ->active()
                                ->where('vehicle_make_id', $currentCategory->id)));
                });
            $isVehicleMake = true;
        } else {
            $currentCategory = $rootCategory->children()
                ->active()
                ->where('kind', 'special')
                ->where('slug', $category)
                ->firstOrFail();
            $models = collect();
            $productQuery = Product::query()
                ->active()
                ->whereHas('categories', fn (Builder $query) => $query->whereKey($currentCategory->id));
            $isVehicleMake = false;
        }

        [$products, $filterOptions, $filters, $unfilteredProductCount] = $this->filteredProducts($request, $productQuery, $productFilter);

        return view('catalog.categories.show', compact(
            'rootCategory',
            'currentCategory',
            'models',
            'products',
            'isVehicleMake',
            'filterOptions',
            'filters',
            'unfilteredProductCount',
        ));
    }

    public function showModel(Request $request, string $category, string $model, CatalogProductFilter $productFilter): View
    {
        $rootCategory = $this->rootCategory();
        $currentCategory = $rootCategory->vehicleMakes()
            ->active()
            ->where('slug', $category)
            ->firstOrFail();
        $currentModel = $currentCategory->models()
            ->active()
            ->where('slug', $model)
            ->firstOrFail();
        $bodyTypes = $currentModel->bodyTypes()->active()->get();
        [$products, $filterOptions, $filters, $unfilteredProductCount] = $this->filteredProducts(
            $request,
            Product::query()
                ->active()
                ->where(function (Builder $query) use ($currentModel): void {
                    $query->whereHas('vehicleModels', fn (Builder $models) => $models->whereKey($currentModel->id))
                        ->orWhereHas('vehicleBodyTypes', fn (Builder $bodyTypes) => $bodyTypes
                            ->active()
                            ->where('vehicle_model_id', $currentModel->id));
                }),
            $productFilter,
        );

        return view('catalog.models.show', compact(
            'rootCategory',
            'currentCategory',
            'currentModel',
            'bodyTypes',
            'products',
            'filterOptions',
            'filters',
            'unfilteredProductCount',
        ));
    }

    public function showBodyType(
        Request $request,
        string $category,
        string $model,
        string $bodyType,
        CatalogProductFilter $productFilter,
    ): View {
        $rootCategory = $this->rootCategory();
        $currentCategory = $rootCategory->vehicleMakes()
            ->active()
            ->where('slug', $category)
            ->firstOrFail();
        $currentModel = $currentCategory->models()
            ->active()
            ->where('slug', $model)
            ->firstOrFail();
        $currentBodyType = $currentModel->bodyTypes()
            ->active()
            ->where('slug', $bodyType)
            ->firstOrFail();

        [$products, $filterOptions, $filters, $unfilteredProductCount] = $this->filteredProducts(
            $request,
            Product::query()
                ->active()
                ->where(function (Builder $query) use ($currentModel, $currentBodyType): void {
                    $query->whereHas('vehicleModels', fn (Builder $models) => $models->whereKey($currentModel->id))
                        ->orWhereHas('vehicleBodyTypes', fn (Builder $bodyTypes) => $bodyTypes
                            ->active()
                            ->whereKey($currentBodyType->id));
                }),
            $productFilter,
        );

        return view('catalog.body-types.show', compact(
            'rootCategory',
            'currentCategory',
            'currentModel',
            'currentBodyType',
            'products',
            'filterOptions',
            'filters',
            'unfilteredProductCount',
        ));
    }

    /** @return array{0: Collection, 1: array<string, mixed>, 2: array<string, mixed>, 3: int} */
    private function filteredProducts(Request $request, Builder $query, CatalogProductFilter $productFilter): array
    {
        $availableProducts = (clone $query)->with('roofRack.manufacturer')->orderBy('name')->get();
        $filters = $productFilter->values($request);
        $products = $productFilter->apply(clone $query, $filters)
            ->with(['images', 'roofRack.manufacturer'])
            ->orderBy('name')
            ->get();

        return [$products, $productFilter->options($availableProducts), $filters, $availableProducts->count()];
    }

    private function rootCategory(): CatalogCategory
    {
        return CatalogCategory::query()
            ->active()
            ->whereNull('parent_id')
            ->where('slug', 'autobagazhniki')
            ->firstOrFail();
    }
}

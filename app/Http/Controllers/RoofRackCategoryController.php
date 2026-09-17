<?php

namespace App\Http\Controllers;

use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\VehicleMake;
use App\Services\CatalogProductFilter;
use App\Services\VehicleCatalogService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class RoofRackCategoryController extends Controller
{
    public function index(Request $request, CatalogProductFilter $productFilter): View
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

        $selectedVehicle = $request->attributes->get('vehicleConfiguration');
        $products = collect();
        $filterOptions = [];
        $filters = [];
        $unfilteredProductCount = 0;
        if ($selectedVehicle) {
            [$products, $filterOptions, $filters, $unfilteredProductCount] = $this->filteredProducts(
                $request,
                Product::query()->active()->whereHas('roofRack'),
                $productFilter,
            );
        }

        return view('catalog.categories.index', compact(
            'rootCategory', 'categories', 'selectedVehicle', 'products', 'filterOptions', 'filters', 'unfilteredProductCount',
        ));
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
            $popularModels = $this->popularModels($currentCategory, $models);
            $productQuery = Product::query()
                ->active()
                ->whereHas('roofRack')
                ->whereHas('fitments', fn (Builder $fitments) => $fitments
                    ->active()
                    ->where('fitment_product.status', 'active')
                    ->whereHas('configurations.generation.vehicleModel', fn (Builder $models) => $models
                        ->active()
                        ->where('vehicle_make_id', $currentCategory->id)));
            $isVehicleMake = true;
        } else {
            $currentCategory = $rootCategory->children()
                ->active()
                ->where('kind', 'special')
                ->where('slug', $category)
                ->firstOrFail();
            $models = collect();
            $popularModels = collect();
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
            'popularModels',
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
        $generations = $currentModel->generations()
            ->active()
            ->whereHas('configurations', fn (Builder $configurations) => $configurations->active())
            ->withCount(['configurations' => fn (Builder $configurations) => $configurations->active()])
            ->get();
        [$products, $filterOptions, $filters, $unfilteredProductCount] = $this->filteredProducts(
            $request,
            Product::query()
                ->active()
                ->whereHas('roofRack')
                ->whereHas('fitments', fn (Builder $fitments) => $fitments
                    ->active()
                    ->where('fitment_product.status', 'active')
                    ->whereHas('configurations.generation', fn (Builder $generations) => $generations
                        ->active()
                        ->where('vehicle_model_id', $currentModel->id))),
            $productFilter,
        );

        return view('catalog.models.show', compact(
            'rootCategory',
            'currentCategory',
            'currentModel',
            'generations',
            'products',
            'filterOptions',
            'filters',
            'unfilteredProductCount',
        ));
    }

    public function showGeneration(
        Request $request,
        string $category,
        string $model,
        string $generation,
        CatalogProductFilter $productFilter,
    ): View|RedirectResponse {
        $rootCategory = $this->rootCategory();
        $currentCategory = $rootCategory->vehicleMakes()
            ->active()
            ->where('slug', $category)
            ->firstOrFail();
        $currentModel = $currentCategory->models()
            ->active()
            ->where('slug', $model)
            ->firstOrFail();
        $currentGeneration = $currentModel->generations()
            ->active()
            ->where('slug', $generation)
            ->first();

        if (! $currentGeneration) {
            $legacyConfiguration = $currentModel->generations()
                ->whereHas('configurations', fn (Builder $configurations) => $configurations
                    ->active()
                    ->where('slug', $generation))
                ->with(['configurations' => fn ($configurations) => $configurations
                    ->active()
                    ->where('slug', $generation)])
                ->firstOrFail();

            return redirect()->route('catalog.autobagazhniki.configuration.show', [
                $currentCategory->slug,
                $currentModel->slug,
                $legacyConfiguration->slug,
                $legacyConfiguration->configurations->first()->slug,
            ], 301);
        }

        $configurations = $currentGeneration->configurations()
            ->active()
            ->with(['bodyStyle', 'roofType'])
            ->get();

        [$products, $filterOptions, $filters, $unfilteredProductCount] = $this->filteredProducts(
            $request,
            Product::query()
                ->active()
                ->whereHas('roofRack')
                ->whereHas('fitments', fn (Builder $fitments) => $fitments
                    ->active()
                    ->where('fitment_product.status', 'active')
                    ->whereHas('configurations', fn (Builder $configurations) => $configurations
                        ->active()
                        ->where('vehicle_generation_id', $currentGeneration->id))),
            $productFilter,
        );

        return view('catalog.generations.show', compact(
            'rootCategory',
            'currentCategory',
            'currentModel',
            'currentGeneration',
            'configurations',
            'products',
            'filterOptions',
            'filters',
            'unfilteredProductCount',
        ));
    }

    public function showConfiguration(
        Request $request,
        string $category,
        string $model,
        string $generation,
        string $configuration,
        CatalogProductFilter $productFilter,
    ): View {
        $rootCategory = $this->rootCategory();
        $currentCategory = $rootCategory->vehicleMakes()->active()->where('slug', $category)->firstOrFail();
        $currentModel = $currentCategory->models()->active()->where('slug', $model)->firstOrFail();
        $currentGeneration = $currentModel->generations()->active()->where('slug', $generation)->firstOrFail();
        $currentConfiguration = $currentGeneration->configurations()
            ->active()
            ->with(['bodyStyle', 'roofType'])
            ->where('slug', $configuration)
            ->firstOrFail();

        [$products, $filterOptions, $filters, $unfilteredProductCount] = $this->filteredProducts(
            $request,
            Product::query()
                ->active()
                ->whereHas('roofRack')
                ->whereHas('fitments', fn (Builder $fitments) => $fitments
                    ->active()
                    ->where('fitment_product.status', 'active')
                    ->whereHas('configurations', fn (Builder $configurations) => $configurations
                        ->whereKey($currentConfiguration->id))),
            $productFilter,
        );

        return view('catalog.configurations.show', compact(
            'rootCategory', 'currentCategory', 'currentModel', 'currentGeneration', 'currentConfiguration',
            'products', 'filterOptions', 'filters', 'unfilteredProductCount',
        ));
    }

    /** @return array{0: Collection, 1: array<string, mixed>, 2: array<string, mixed>, 3: int} */
    private function filteredProducts(Request $request, Builder $query, CatalogProductFilter $productFilter): array
    {
        $selectedVehicle = $request->attributes->get('vehicleConfiguration');
        if ($selectedVehicle) {
            $query->whereKey(app(VehicleCatalogService::class)->compatibleRoofRackIds($selectedVehicle));
        }

        $availableProducts = (clone $query)->with('roofRack.manufacturer')->orderBy('name')->get();
        $filters = $productFilter->values($request);
        $products = $productFilter->applySorting($productFilter->apply(clone $query, $filters), $filters)
            ->with(['images', 'roofRack.manufacturer'])
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

    /**
     * Быстрые ссылки на наиболее востребованные модели поддерживаются отдельно
     * от порядка полного справочника: сортировка в нём не означает популярность.
     */
    private function popularModels(VehicleMake $make, Collection $models): Collection
    {
        $popularModelNames = [
            'toyota' => ['Camry', 'RAV 4', 'Corolla', 'Land Cruiser', 'Highlander'],
        ];

        return $models
            ->keyBy('name')
            ->only($popularModelNames[$make->slug] ?? [])
            ->values();
    }
}

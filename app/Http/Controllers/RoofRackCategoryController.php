<?php

namespace App\Http\Controllers;

use App\Models\CatalogCategory;
use App\Models\VehicleMake;
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

    public function show(string $category): View
    {
        $rootCategory = $this->rootCategory();
        $currentCategory = $rootCategory->vehicleMakes()
            ->active()
            ->where('slug', $category)
            ->first();

        if ($currentCategory) {
            $models = $currentCategory->models()->active()->get();
            $isVehicleMake = true;
        } else {
            $currentCategory = $rootCategory->children()
                ->active()
                ->where('kind', 'special')
                ->where('slug', $category)
                ->firstOrFail();
            $models = collect();
            $isVehicleMake = false;
        }

        return view('catalog.categories.show', compact('rootCategory', 'currentCategory', 'models', 'isVehicleMake'));
    }

    public function showModel(string $category, string $model): View
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

        return view('catalog.models.show', compact('rootCategory', 'currentCategory', 'currentModel'));
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

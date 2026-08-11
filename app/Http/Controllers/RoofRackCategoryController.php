<?php

namespace App\Http\Controllers;

use App\Models\CatalogCategory;
use Illuminate\View\View;

class RoofRackCategoryController extends Controller
{
    public function index(): View
    {
        $rootCategory = $this->rootCategory();
        $categories = $rootCategory->children()
            ->active()
            ->get();

        return view('catalog.categories.index', compact('rootCategory', 'categories'));
    }

    public function show(string $category): View
    {
        $rootCategory = $this->rootCategory();
        $currentCategory = $rootCategory->children()
            ->active()
            ->where('slug', $category)
            ->firstOrFail();

        return view('catalog.categories.show', compact('rootCategory', 'currentCategory'));
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

<?php

namespace App\Http\Controllers;

use App\Models\CatalogCategory;
use App\Models\Product;
use App\Services\AutoBoxProductFilter;
use App\Services\VehicleCatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AutoBoxController extends Controller
{
    public function __invoke(Request $request, AutoBoxProductFilter $productFilter, VehicleCatalogService $vehicleCatalog): View
    {
        $section = CatalogCategory::query()
            ->active()
            ->whereNull('parent_id')
            ->where('slug', 'autobox')
            ->firstOrFail();
        $productQuery = Product::query()
            ->active()
            ->whereHas('autoBox');
        $selectedVehicle = $request->attributes->get('vehicleConfiguration');
        if ($selectedVehicle) {
            $productQuery->whereKey($vehicleCatalog->compatibleAutoBoxIds($selectedVehicle));
        }
        $availableProducts = (clone $productQuery)
            ->with(['autoBox.manufacturer'])
            ->orderBy('name')
            ->get();
        $filters = $productFilter->values($request);
        $products = $productFilter->apply(clone $productQuery, $filters)
            ->with(['images', 'autoBox.manufacturer'])
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();
        $filterOptions = $productFilter->options($availableProducts);
        $unfilteredProductCount = $availableProducts->count();

        return view('catalog.auto-boxes.index', compact(
            'section',
            'products',
            'filters',
            'filterOptions',
            'unfilteredProductCount',
        ));
    }
}

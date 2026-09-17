<?php

namespace App\Http\Controllers;

use App\Models\CatalogCategory;
use App\Models\Product;
use App\Services\BikeRackProductFilter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BikeRackController extends Controller
{
    public function __invoke(Request $request, BikeRackProductFilter $productFilter): View
    {
        $section = CatalogCategory::query()
            ->active()
            ->whereNull('parent_id')
            ->where('slug', 'velokrepleniya')
            ->firstOrFail();
        $productQuery = Product::query()
            ->active()
            ->whereHas('bikeRack');
        $availableProducts = (clone $productQuery)
            ->with(['images', 'bikeRack.manufacturer'])
            ->orderBy('name')
            ->get();
        $filters = $productFilter->values($request);
        $products = $productFilter->applySorting($productFilter->apply(clone $productQuery, $filters), $filters)
            ->with(['images', 'bikeRack.manufacturer'])
            ->paginate(12)
            ->withQueryString();
        $filterOptions = $productFilter->options($availableProducts);
        $unfilteredProductCount = $availableProducts->count();

        return view('catalog.bike-racks.index', compact('section', 'products', 'filters', 'filterOptions', 'unfilteredProductCount'));
    }
}

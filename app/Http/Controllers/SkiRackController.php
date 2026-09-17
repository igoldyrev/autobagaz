<?php

namespace App\Http\Controllers;

use App\Models\CatalogCategory;
use App\Models\Product;
use App\Services\SkiRackProductFilter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkiRackController extends Controller
{
    public function __invoke(Request $r, SkiRackProductFilter $filter): View
    {
        $section = CatalogCategory::query()->active()->whereNull('parent_id')->where('slug', 'krepleniya-dlya-lyzh-i-snoubordov')->firstOrFail();
        $q = Product::query()->active()->whereHas('skiRack');
        $available = (clone $q)->with('skiRack.manufacturer')->orderBy('name')->get();
        $filters = $filter->values($r);
        $products = $filter->applySorting($filter->apply(clone $q, $filters), $filters)->with(['images', 'skiRack.manufacturer'])->paginate(12)->withQueryString();
        $filterOptions = $filter->options($available);
        $unfilteredProductCount = $available->count();

        return view('catalog.ski-racks.index', compact('section', 'products', 'filters', 'filterOptions', 'unfilteredProductCount'));
    }
}

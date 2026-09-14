<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\View\View;

class ProductSectionController extends Controller
{
    public function __invoke(): View
    {
        $roofRackProductsCount = Product::query()->whereHas('roofRack')->count();
        $autoBoxProductsCount = Product::query()->whereHas('autoBox')->count();
        $bikeRackProductsCount = Product::query()->whereHas('bikeRack')->count();
        $skiRackProductsCount = Product::query()->whereHas('skiRack')->count();
        $productTypes = ProductType::query()->orderBy('name')->get()->keyBy('code');

        return view('admin.product-sections.index', compact('roofRackProductsCount', 'autoBoxProductsCount', 'bikeRackProductsCount', 'skiRackProductsCount', 'productTypes'));
    }
}

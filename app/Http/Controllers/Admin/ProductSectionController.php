<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ProductSectionController extends Controller
{
    public function __invoke(): View
    {
        $roofRackProductsCount = Product::query()->whereHas('roofRack')->count();
        $autoBoxProductsCount = Product::query()->whereHas('autoBox')->count();

        return view('admin.product-sections.index', compact('roofRackProductsCount', 'autoBoxProductsCount'));
    }
}

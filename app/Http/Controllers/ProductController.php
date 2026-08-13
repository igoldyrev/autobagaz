<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);
        $product->load(['images', 'categories', 'vehicleModels.make', 'roofRack']);

        return view('catalog.products.show', compact('product'));
    }
}

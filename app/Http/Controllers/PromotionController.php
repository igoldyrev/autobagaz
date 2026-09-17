<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class PromotionController extends Controller
{
    public function __invoke(): View
    {
        $products = Schema::hasColumns('products', ['old_price', 'is_on_sale', 'promotion_starts_at', 'promotion_ends_at'])
            ? Product::query()
                ->active()
                ->onSale()
                ->with('images')
                ->orderByDesc('catalog_priority')
                ->orderByDesc('promotion_starts_at')
                ->paginate(24)
            : Product::query()->whereRaw('1 = 0')->paginate(24);

        return view('promotions.index', compact('products'));
    }
}

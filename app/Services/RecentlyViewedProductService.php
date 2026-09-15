<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class RecentlyViewedProductService
{
    private const SESSION_KEY = 'recently_viewed_products';

    private const LIMIT = 4;

    public function remember(Product $product): void
    {
        $productIds = collect(Session::get(self::SESSION_KEY, []))
            ->reject(fn ($id) => (int) $id === $product->id)
            ->prepend($product->id)
            ->take(self::LIMIT)
            ->values()
            ->all();

        Session::put(self::SESSION_KEY, $productIds);
    }

    /** @return Collection<int, Product> */
    public function products(): Collection
    {
        $productIds = collect(Session::get(self::SESSION_KEY, []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->take(self::LIMIT)
            ->values();

        if ($productIds->isEmpty()) {
            return collect();
        }

        $products = Product::query()
            ->active()
            ->with('images')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        return $productIds->map(fn (int $id) => $products->get($id))->filter()->values();
    }
}

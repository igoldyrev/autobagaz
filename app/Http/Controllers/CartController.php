<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Models\Product;
use App\Services\CartService;
use App\Services\RecentlyViewedProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(CartService $cart, RecentlyViewedProductService $recentlyViewed): View
    {
        return view('cart.index', [
            'items' => $cart->contents(),
            'total' => $cart->total(),
            'recentProducts' => $recentlyViewed->products(),
        ]);
    }

    public function store(CartItemRequest $request, Product $product, CartService $cart): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $cart->add($product, $request->integer('quantity', 1));

        return to_route('cart.index')->with('success', 'Товар добавлен в корзину.');
    }

    public function update(CartItemRequest $request, Product $product, CartService $cart): RedirectResponse|JsonResponse
    {
        $quantity = $request->integer('quantity');
        $cart->update($product, $quantity);

        if ($request->expectsJson()) {
            return response()->json([
                'line_total' => (float) $product->price * $quantity,
                'cart_total' => $cart->total(),
                'cart_count' => $cart->count(),
            ]);
        }

        return to_route('cart.index')->with('success', 'Корзина обновлена.');
    }

    public function destroy(Product $product, CartService $cart): RedirectResponse
    {
        $cart->remove($product);

        return to_route('cart.index')->with('success', 'Товар удалён из корзины.');
    }
}

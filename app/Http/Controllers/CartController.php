<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Models\Product;
use App\Services\CartService;
use App\Services\RecentlyViewedProductService;
use App\Services\RoofRackRecommendationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request, CartService $cart, RecentlyViewedProductService $recentlyViewed, RoofRackRecommendationService $roofRackRecommendations): View
    {
        $items = $cart->contents();
        $products = $items->pluck('product');
        $products->each(fn (Product $product) => $product->load(['autoBox', 'bikeRack', 'skiRack', 'roofRack']));
        $accessory = $products->first(fn (Product $product): bool => $roofRackRecommendations->requiresRoofRack($product));
        $hasRoofRack = $products->contains(fn (Product $product): bool => $product->roofRack !== null);
        $selectedVehicle = $request->attributes->get('vehicleConfiguration');
        $recommendedRoofRack = $selectedVehicle && $accessory && ! $hasRoofRack
            ? $roofRackRecommendations->recommend($accessory, $selectedVehicle)
            : null;
        $installationService = $cart->selectedInstallationService();

        return view('cart.index', [
            'items' => $items,
            'total' => $cart->total($installationService),
            'installationService' => $installationService,
            'recentProducts' => $recentlyViewed->products(),
            'roofRackAccessory' => $accessory,
            'recommendedRoofRack' => $recommendedRoofRack,
            'hasInstallationKit' => $accessory !== null && $hasRoofRack,
        ]);
    }

    public function store(CartItemRequest $request, Product $product, CartService $cart): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $cart->add($product, $request->integer('quantity', 1));

        return to_route('cart.index')->with('success', 'Товар добавлен в корзину.');
    }

    public function storeKit(Request $request, Product $product, Product $roofRack, CartService $cart, RoofRackRecommendationService $roofRackRecommendations): RedirectResponse
    {
        abort_unless($product->is_active && $roofRack->is_active && $roofRack->roofRack, 404);

        $vehicle = $request->attributes->get('vehicleConfiguration');
        $recommendedRoofRack = $vehicle ? $roofRackRecommendations->recommend($product, $vehicle) : null;
        if (! $recommendedRoofRack || $recommendedRoofRack->isNot($roofRack)) {
            return to_route('products.show', $product)->with('error', 'Не удалось подтвердить совместимость комплекта. Выберите автомобиль и попробуйте снова.');
        }

        $cart->add($product);
        $cart->add($roofRack);

        if ($request->boolean('installation_service')) {
            $cart->addInstallationService();
        }

        return to_route('cart.index')->with('success', 'Комплект добавлен в корзину.');
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

    public function destroyInstallationService(CartService $cart): RedirectResponse
    {
        $cart->removeInstallationService();

        return to_route('cart.index')->with('success', 'Услуга установки удалена из корзины.');
    }
}

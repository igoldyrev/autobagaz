<?php

namespace App\Services;

use App\Models\InstallationService;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'cart.items';

    private const INSTALLATION_SERVICE_SESSION_KEY = 'cart.installation_service';

    public function add(Product $product, int $quantity = 1): void
    {
        $items = $this->rawItems();
        $id = (string) $product->id;
        $items[$id] = min(100, ($items[$id] ?? 0) + $quantity);
        Session::put(self::SESSION_KEY, $items);
    }

    public function update(Product $product, int $quantity): void
    {
        $items = $this->rawItems();
        $id = (string) $product->id;

        if ($quantity === 0) {
            unset($items[$id]);
        } else {
            $items[$id] = min(100, $quantity);
        }

        Session::put(self::SESSION_KEY, $items);
    }

    public function remove(Product $product): void
    {
        $this->update($product, 0);
    }

    /** @return Collection<int, array{product: Product, quantity: int, total: float}> */
    public function contents(): Collection
    {
        $items = $this->rawItems();
        if ($items === []) {
            return collect();
        }

        $products = Product::query()->active()->whereIn('id', array_keys($items))->get()->keyBy('id');
        $validItems = [];

        $contents = collect($items)->map(function (int $quantity, string $productId) use ($products, &$validItems) {
            $product = $products->get((int) $productId);
            if (! $product) {
                return null;
            }

            $validItems[$product->id] = $quantity;

            return [
                'product' => $product,
                'quantity' => $quantity,
                'total' => (float) $product->price * $quantity,
            ];
        })->filter()->values();

        if ($validItems !== $items) {
            Session::put(self::SESSION_KEY, $validItems);
        }

        return $contents;
    }

    public function addInstallationService(): void
    {
        if (InstallationService::query()->available()->exists()) {
            Session::put(self::INSTALLATION_SERVICE_SESSION_KEY, true);
        }
    }

    public function removeInstallationService(): void
    {
        Session::forget(self::INSTALLATION_SERVICE_SESSION_KEY);
    }

    public function selectedInstallationService(): ?InstallationService
    {
        if (! Session::get(self::INSTALLATION_SERVICE_SESSION_KEY, false)) {
            return null;
        }

        $service = InstallationService::query()->available()->first();
        if (! $service) {
            $this->removeInstallationService();
        }

        return $service;
    }

    public function total(?InstallationService $installationService = null): float
    {
        $installationService ??= $this->selectedInstallationService();

        return $this->contents()->sum('total') + ($installationService ? (float) $installationService->price : 0);
    }

    public function count(): int
    {
        return array_sum($this->rawItems());
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
        $this->removeInstallationService();
    }

    /** @return array<string, int> */
    private function rawItems(): array
    {
        return collect(Session::get(self::SESSION_KEY, []))
            ->mapWithKeys(fn ($quantity, $id) => [(string) $id => max(1, min(100, (int) $quantity))])
            ->all();
    }
}

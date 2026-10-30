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

        $products = Product::query()->withAvailability()->active()->whereIn('id', array_keys($items))->get()->keyBy('id');
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

    /**
     * Read checkout conditions without silently removing unavailable cart entries.
     * With locking enabled, these same conditions must be used to create the order.
     *
     * @return array<string, array{name: string, price: int, quantity: int, stock: int|null, product_id: int|null}>
     */
    public function checkoutSnapshot(bool $lock = false): array
    {
        $quantities = $this->rawItems();
        $query = Product::query()->whereIn('id', array_keys($quantities))->orderBy('id');
        $products = ($lock ? $query->lockForUpdate() : $query)->get();
        $snapshot = [];

        foreach ($products as $product) {
            if (! $product->is_active) {
                continue;
            }

            $snapshot['product:'.$product->id] = [
                'name' => $product->name,
                'price' => $this->priceInKopecks($product->price),
                'quantity' => $quantities[$product->id],
                'stock' => $product->available_stock,
                'product_id' => $product->id,
            ];
        }

        if (Session::get(self::INSTALLATION_SERVICE_SESSION_KEY, false)) {
            $query = InstallationService::query()->orderBy('id');
            $services = ($lock ? $query->lockForUpdate() : $query)->get();
            $service = $services->first(fn (InstallationService $service) => $service->is_available);
            if ($service && $snapshot !== []) {
                $snapshot['installation:'.$service->id] = [
                    'name' => $service->name,
                    'price' => $this->priceInKopecks($service->price),
                    'quantity' => 1,
                    'stock' => null,
                    'product_id' => null,
                ];
            }
        }

        return $snapshot;
    }

    public function checkoutChanges(array $previous, array $current): array
    {
        $changes = [];
        foreach ($previous as $key => $before) {
            $after = $current[$key] ?? null;
            $name = $before['name'];
            if ($after === null) {
                if ($before['product_id'] !== null) {
                    $available = Product::query()->active()->whereKey($before['product_id'])->exists();
                    $changes[] = $name.($available ? ' — удалён из корзины.' : ' — больше недоступен.');
                } else {
                    $available = InstallationService::query()->available()->whereKey(substr($key, strlen('installation:')))->exists();
                    $changes[] = $name.($available ? ' — услуга установки удалена из корзины.' : ' — больше недоступна.');
                }

                continue;
            }
            if ($before['name'] !== $after['name']) {
                $changes[] = $name.' — новое название: '.$after['name'].'.';
            }
            if ($before['price'] !== $after['price']) {
                $changes[] = $name.' — цена: '.$this->formatCheckoutPrice($before['price']).' → '.$this->formatCheckoutPrice($after['price']).'.';
            }
            if ($before['quantity'] !== $after['quantity']) {
                $changes[] = $name.' — количество: '.$before['quantity'].' → '.$after['quantity'].'.';
            }
            if ($before['stock'] !== $after['stock']) {
                $availability = fn ($stock) => $stock > 0 ? 'в наличии '.$stock.' шт.' : 'под заказ';
                $changes[] = $name.' — наличие: '.$availability($before['stock']).' → '.rtrim($availability($after['stock']), '.').'.';
            }
        }
        foreach (array_diff_key($current, $previous) as $item) {
            $changes[] = $item['name'].' — добавлено: '.$item['quantity'].' шт., '.$this->formatCheckoutPrice($item['price']).' за единицу.';
        }

        return $changes;
    }

    private function priceInKopecks(string $price): int
    {
        [$rubles, $kopecks] = explode('.', $price.'.00');

        return (int) $rubles * 100 + (int) str_pad($kopecks, 2, '0');
    }

    private function formatCheckoutPrice(int $kopecks): string
    {
        return number_format($kopecks / 100, 2, ',', ' ').' ₽';
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

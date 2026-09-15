<?php

namespace App\Services;

use App\Compatibility\CompatibilityContext;
use App\Compatibility\CompatibilityResult;
use App\Models\Product;
use App\Models\VehicleConfiguration;
use Illuminate\Support\Facades\Cache;

class VehicleCatalogService
{
    private const CACHE_VERSION_KEY = 'vehicle-catalog:version';

    public function __construct(private readonly CompatibilityService $compatibility) {}

    /** @return array<int> */
    public function compatibleRoofRackIds(VehicleConfiguration $configuration): array
    {
        return $this->summary($configuration)['roof_rack_ids'];
    }

    /** @return array<int> */
    public function compatibleAutoBoxIds(VehicleConfiguration $configuration): array
    {
        return $this->summary($configuration)['auto_box_ids'];
    }

    /** @return array{roof_rack_ids: array<int>, auto_box_ids: array<int>, bike_rack_ids: array<int>, ski_rack_ids: array<int>, roof_rack_count: int, auto_box_count: int, bike_rack_count: int, ski_rack_count: int} */
    public function summary(VehicleConfiguration $configuration): array
    {
        $version = (int) Cache::get(self::CACHE_VERSION_KEY, 1);

        return Cache::remember(
            'vehicle-catalog:v'.$version.':types-v2:configuration:'.$configuration->id,
            now()->addMinutes(15),
            fn (): array => $this->calculate($configuration),
        );
    }

    public static function invalidate(): void
    {
        Cache::forever(self::CACHE_VERSION_KEY, (int) Cache::get(self::CACHE_VERSION_KEY, 1) + 1);
    }

    /** @return array{roof_rack_ids: array<int>, auto_box_ids: array<int>, bike_rack_ids: array<int>, ski_rack_ids: array<int>, roof_rack_count: int, auto_box_count: int, bike_rack_count: int, ski_rack_count: int} */
    private function calculate(VehicleConfiguration $configuration): array
    {
        $context = new CompatibilityContext($configuration);
        $roofRacks = Product::query()
            ->active()
            ->whereHas('roofRack')
            ->with([
                'productType',
                'roofRack',
                'fitments' => fn ($query) => $query->active()->wherePivot('status', 'active'),
                'fitments.configurations' => fn ($query) => $query->whereKey($configuration->id),
            ])
            ->get()
            ->filter(fn (Product $product): bool => $this->compatibility->check($product, $context)->status === CompatibilityResult::COMPATIBLE)
            ->values();

        $autoBoxIds = Product::query()
            ->active()
            ->whereHas('autoBox')
            ->with(['productType', 'autoBox'])
            ->get()
            ->filter(fn (Product $autoBox): bool => $this->compatibility
                ->check($autoBox, $context)
                ->status === CompatibilityResult::COMPATIBLE)
            ->modelKeys();
        $roofRackIds = $roofRacks->modelKeys();
        $bikeRackIds = Product::query()->active()->whereHas('bikeRack')->orderBy('name')->pluck('id')->all();
        $skiRackIds = Product::query()->active()->whereHas('skiRack')->orderBy('name')->pluck('id')->all();

        return [
            'roof_rack_ids' => $roofRackIds,
            'auto_box_ids' => $autoBoxIds,
            'bike_rack_ids' => $bikeRackIds,
            'ski_rack_ids' => $skiRackIds,
            'roof_rack_count' => count($roofRackIds),
            'auto_box_count' => count($autoBoxIds),
            'bike_rack_count' => count($bikeRackIds),
            'ski_rack_count' => count($skiRackIds),
        ];
    }
}

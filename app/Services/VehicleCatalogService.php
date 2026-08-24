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

    /** @return array{roof_rack_ids: array<int>, auto_box_ids: array<int>, roof_rack_count: int, auto_box_count: int} */
    public function summary(VehicleConfiguration $configuration): array
    {
        $version = (int) Cache::get(self::CACHE_VERSION_KEY, 1);

        return Cache::remember(
            'vehicle-catalog:v'.$version.':configuration:'.$configuration->id,
            now()->addMinutes(15),
            fn (): array => $this->calculate($configuration),
        );
    }

    public static function invalidate(): void
    {
        Cache::forever(self::CACHE_VERSION_KEY, (int) Cache::get(self::CACHE_VERSION_KEY, 1) + 1);
    }

    /** @return array{roof_rack_ids: array<int>, auto_box_ids: array<int>, roof_rack_count: int, auto_box_count: int} */
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
            ->filter(function (Product $autoBox) use ($configuration, $roofRacks): bool {
                foreach ($roofRacks as $roofRack) {
                    $result = $this->compatibility->check($autoBox, new CompatibilityContext($configuration, $roofRack));
                    if ($result->status === CompatibilityResult::COMPATIBLE) {
                        return true;
                    }
                }

                return false;
            })
            ->modelKeys();
        $roofRackIds = $roofRacks->modelKeys();

        return [
            'roof_rack_ids' => $roofRackIds,
            'auto_box_ids' => $autoBoxIds,
            'roof_rack_count' => count($roofRackIds),
            'auto_box_count' => count($autoBoxIds),
        ];
    }
}

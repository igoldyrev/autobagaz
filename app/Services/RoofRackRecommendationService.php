<?php

namespace App\Services;

use App\Compatibility\CompatibilityContext;
use App\Compatibility\CompatibilityResult;
use App\Models\Product;
use App\Models\VehicleConfiguration;

class RoofRackRecommendationService
{
    public function __construct(
        private readonly VehicleCatalogService $vehicleCatalog,
        private readonly CompatibilityService $compatibility,
    ) {}

    public function requiresRoofRack(Product $product): bool
    {
        $product->loadMissing(['autoBox', 'bikeRack', 'skiRack']);

        return $product->autoBox
            || $product->skiRack
            || $product->bikeRack?->mounting_type === 'На крышу';
    }

    public function recommend(Product $accessory, VehicleConfiguration $vehicle): ?Product
    {
        if (! $this->requiresRoofRack($accessory)) {
            return null;
        }

        $roofRackIds = $this->vehicleCatalog->compatibleRoofRackIds($vehicle);
        if ($roofRackIds === []) {
            return null;
        }

        $roofRacks = Product::query()
            ->active()
            ->whereIn('id', $roofRackIds)
            ->whereHas('roofRack')
            ->with(['productType', 'roofRack'])
            ->orderBy('price')
            ->orderBy('name')
            ->get();

        if (! $accessory->autoBox) {
            return $roofRacks->first();
        }

        return $roofRacks->first(fn (Product $roofRack): bool => $this->compatibility
            ->check($accessory, new CompatibilityContext($vehicle, $roofRack))
            ->status === CompatibilityResult::COMPATIBLE);
    }
}

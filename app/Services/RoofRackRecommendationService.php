<?php

namespace App\Services;

use App\Compatibility\CompatibilityContext;
use App\Compatibility\CompatibilityResult;
use App\Models\Product;
use App\Models\VehicleConfiguration;
use Illuminate\Support\Facades\Session;

class RoofRackRecommendationService
{
    public const OWN_CROSSBARS_SESSION_KEY = 'installation.own_crossbars';

    private array $roofRacksByVehicle = [];

    public function __construct(
        private readonly VehicleCatalogService $vehicleCatalog,
        private readonly CompatibilityService $compatibility,
    ) {}

    public function ownsCrossbars(): bool
    {
        return (bool) Session::get(self::OWN_CROSSBARS_SESSION_KEY, false);
    }

    public function setOwnCrossbars(bool $ownsCrossbars): void
    {
        Session::put(self::OWN_CROSSBARS_SESSION_KEY, $ownsCrossbars);
    }

    public function requiresTowbar(Product $product): bool
    {
        $product->loadMissing('bikeRack');

        return $product->bikeRack?->mounting_type === 'На фаркоп';
    }

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

        $roofRacks = $this->roofRacksByVehicle[$vehicle->id] ??= Product::query()
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

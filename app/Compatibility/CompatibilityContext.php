<?php

namespace App\Compatibility;

use App\Models\Product;
use App\Models\VehicleConfiguration;

readonly class CompatibilityContext
{
    public function __construct(
        public VehicleConfiguration $vehicleConfiguration,
        public ?Product $baseProduct = null,
    ) {}
}

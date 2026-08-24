<?php

namespace App\Providers;

use App\Models\AutoBoxProduct;
use App\Models\CompatibilityOverride;
use App\Models\Fitment;
use App\Models\Product;
use App\Models\RoofRackProduct;
use App\Models\VehicleConfiguration;
use App\Services\VehicleCatalogService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach ([
            Product::class,
            RoofRackProduct::class,
            AutoBoxProduct::class,
            Fitment::class,
            VehicleConfiguration::class,
            CompatibilityOverride::class,
        ] as $model) {
            $model::saved(fn () => VehicleCatalogService::invalidate());
            $model::deleted(fn () => VehicleCatalogService::invalidate());
        }
    }
}

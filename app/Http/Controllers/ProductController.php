<?php

namespace App\Http\Controllers;

use App\Compatibility\CompatibilityContext;
use App\Models\Product;
use App\Models\ProductPageInformation;
use App\Models\InstallationService;
use App\Models\VehicleConfiguration;
use App\Services\CompatibilityService;
use App\Services\RecentlyViewedProductService;
use App\Services\RoofRackRecommendationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Request $request, Product $product, CompatibilityService $compatibility, RecentlyViewedProductService $recentlyViewed, RoofRackRecommendationService $roofRackRecommendations): View
    {
        abort_unless($product->is_active, 404);
        $product->load([
            'images',
            'categories',
            'productType',
            'roofRack.manufacturer',
            'autoBox.manufacturer',
            'bikeRack.manufacturer',
            'skiRack.manufacturer',
        ]);

        $compatibleVehicles = collect();
        if ($product->roofRack) {
            $product->load([
                'fitments' => fn ($fitments) => $fitments
                    ->active()
                    ->wherePivot('status', 'active')
                    ->with(['configurations' => fn ($configurations) => $configurations
                        ->active()
                        ->whereHas('generation', fn ($generations) => $generations
                            ->active()
                            ->whereHas('vehicleModel', fn ($models) => $models
                                ->active()
                                ->whereHas('make', fn ($makes) => $makes->active())))
                        ->with(['generation.vehicleModel.make', 'bodyStyle', 'roofType'])]),
            ]);
            $compatibleVehicles = $product->fitments
                ->flatMap(fn ($fitment) => $fitment->configurations)
                ->unique('id')
                ->sortBy(fn (VehicleConfiguration $configuration) => implode('|', [
                    $configuration->generation->vehicleModel->make->name,
                    $configuration->generation->vehicleModel->name,
                    $configuration->year_label,
                    $configuration->display_name,
                ]))
                ->values();
        }

        $selectedVehicle = $request->attributes->get('vehicleConfiguration');
        $selectedVehicleYear = $request->attributes->get('vehicleYear');
        $compatibilityResult = $selectedVehicle
            ? $compatibility->check($product, new CompatibilityContext($selectedVehicle))
            : null;
        $selectedVehicleLabel = $selectedVehicle
            ? $this->vehicleLabel($selectedVehicle, $selectedVehicleYear)
            : null;
        $alternativesUrl = $selectedVehicle
            ? $this->alternativesUrl($product, $selectedVehicle->id, $selectedVehicleYear)
            : null;
        $requiresRoofRack = $roofRackRecommendations->requiresRoofRack($product);
        $recommendedRoofRack = $selectedVehicle && $requiresRoofRack
            ? $roofRackRecommendations->recommend($product, $selectedVehicle)
            : null;
        $compatibleVehiclesCountLabel = $this->vehicleCountLabel($compatibleVehicles->count());
        $productPageInformation = ProductPageInformation::query()->firstOrFail();
        $installationService = InstallationService::query()->available()->first();
        $recentlyViewed->remember($product);

        return view('catalog.products.show', compact(
            'product', 'selectedVehicle', 'compatibilityResult', 'selectedVehicleLabel', 'alternativesUrl', 'requiresRoofRack', 'recommendedRoofRack', 'compatibleVehicles', 'compatibleVehiclesCountLabel', 'productPageInformation', 'installationService',
        ));
    }

    private function vehicleCountLabel(int $count): string
    {
        $lastTwoDigits = $count % 100;
        if ($lastTwoDigits >= 11 && $lastTwoDigits <= 14) {
            return 'автомобилей';
        }

        return match ($count % 10) {
            1 => 'автомобиля',
            2, 3, 4 => 'автомобиля',
            default => 'автомобилей',
        };
    }

    private function vehicleLabel(VehicleConfiguration $configuration, ?int $year): string
    {
        $generation = $configuration->generation;
        $generationName = $generation->display_name !== $generation->year_label
            ? $generation->display_name
            : null;

        return collect([
            $generation->vehicleModel->make->name,
            $generation->vehicleModel->name,
            $generationName,
            $year ?: $configuration->year_label,
        ])->filter()->implode(' ');
    }

    private function alternativesUrl(Product $product, int $configurationId, ?int $year): string
    {
        $parameters = array_filter([
            'vehicle_configuration_id' => $configurationId,
            'vehicle_year' => $year,
        ], fn ($value) => $value !== null);

        return route(
            $product->autoBox
                ? 'catalog.auto-boxes.index'
                : ($product->bikeRack ? 'catalog.bike-racks.index' : ($product->skiRack ? 'catalog.ski-racks.index' : 'catalog.autobagazhniki.index')),
            $parameters,
        );
    }
}

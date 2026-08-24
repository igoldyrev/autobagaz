<?php

namespace App\Http\Controllers;

use App\Compatibility\CompatibilityContext;
use App\Models\Product;
use App\Models\VehicleConfiguration;
use App\Services\CompatibilityService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Request $request, Product $product, CompatibilityService $compatibility): View
    {
        abort_unless($product->is_active, 404);
        $product->load([
            'images',
            'categories',
            'productType',
            'roofRack.manufacturer',
            'autoBox.manufacturer',
        ]);

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

        return view('catalog.products.show', compact(
            'product', 'selectedVehicle', 'compatibilityResult', 'selectedVehicleLabel', 'alternativesUrl',
        ));
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
            $product->autoBox ? 'catalog.auto-boxes.index' : 'catalog.autobagazhniki.index',
            $parameters,
        );
    }
}

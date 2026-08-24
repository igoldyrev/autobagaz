<?php

namespace App\Http\Controllers\Admin;

use App\Compatibility\CompatibilityContext;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\VehicleConfiguration;
use App\Services\CompatibilityService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CompatibilityPreviewController extends Controller
{
    public function __invoke(Request $request, CompatibilityService $compatibility): View
    {
        $result = null;
        $selectedProduct = null;
        $selectedBase = null;
        $selectedVehicle = null;

        if ($request->filled(['vehicle_configuration_id', 'product_id'])) {
            $data = $request->validate([
                'vehicle_configuration_id' => ['required', 'integer', Rule::exists('vehicle_configurations', 'id')],
                'product_id' => ['required', 'integer', Rule::exists('products', 'id')],
                'base_product_id' => ['nullable', 'integer', Rule::exists('products', 'id')],
            ]);
            $selectedVehicle = VehicleConfiguration::query()->findOrFail($data['vehicle_configuration_id']);
            $selectedProduct = Product::query()->findOrFail($data['product_id']);
            $selectedBase = filled($data['base_product_id'] ?? null) ? Product::query()->findOrFail($data['base_product_id']) : null;
            $result = $compatibility->check($selectedProduct, new CompatibilityContext($selectedVehicle, $selectedBase));
        }

        return view('admin.compatibility-preview.index', [
            'vehicleConfigurations' => VehicleConfiguration::query()->with('generation.vehicleModel.make')->get()->sortBy(fn ($configuration) => $configuration->generation->vehicleModel->make->name.' '.$configuration->generation->vehicleModel->name.' '.$configuration->display_name),
            'products' => Product::query()->where(fn ($query) => $query->whereHas('roofRack')->orWhereHas('autoBox'))->orderBy('name')->get(),
            'baseProducts' => Product::query()->whereHas('roofRack')->orderBy('name')->get(),
            ...compact('result', 'selectedProduct', 'selectedBase', 'selectedVehicle'),
        ]);
    }
}

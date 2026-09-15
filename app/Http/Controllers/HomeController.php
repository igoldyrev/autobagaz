<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\VehicleMake;
use App\Services\VehicleCatalogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request, VehicleCatalogService $catalog): View
    {
        $vehicleMakes = Schema::hasTable('vehicle_makes')
            ? VehicleMake::query()
                ->active()
                ->orderBy('name')
                ->get(['id', 'name'])
            : collect();

        $selectedVehicle = $request->attributes->get('vehicleConfiguration');
        $homeProducts = collect();

        if ($selectedVehicle) {
            $summary = $catalog->summary($selectedVehicle);
            $productIds = array_slice([
                ...$summary['roof_rack_ids'],
                ...$summary['auto_box_ids'],
            ], 0, 4);

            $homeProducts = Product::query()
                ->whereKey($productIds)
                ->with('images')
                ->orderBy('name')
                ->get();
        }

        return view('home', compact('vehicleMakes', 'homeProducts'));
    }
}

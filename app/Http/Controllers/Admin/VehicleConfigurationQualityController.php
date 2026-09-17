<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleConfiguration;
use Illuminate\View\View;

class VehicleConfigurationQualityController extends Controller
{
    public function __invoke(): View
    {
        $configurations = VehicleConfiguration::query()
            ->with('generation.vehicleModel.make')
            ->whereDoesntHave('fitments', fn ($query) => $query->active())
            ->orderBy('display_name')
            ->paginate(30);

        return view('admin.vehicles.quality-without-fitments', compact('configurations'));
    }
}

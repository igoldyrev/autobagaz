<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleConfiguration;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleConfigurationQualityController extends Controller
{
    public function __invoke(Request $request): View
    {
        $makeId = $request->integer('make_id');
        $modelId = $request->integer('model_id');
        $configurations = VehicleConfiguration::query()
            ->with('generation.vehicleModel.make')
            ->whereDoesntHave('fitments', fn ($query) => $query->active())
            ->when($makeId, fn (Builder $query) => $query->whereHas('generation.vehicleModel', fn (Builder $models) => $models->where('vehicle_make_id', $makeId)))
            ->when($modelId, fn (Builder $query) => $query->whereHas('generation', fn (Builder $generations) => $generations->where('vehicle_model_id', $modelId)))
            ->orderBy('display_name')
            ->orderBy('id')
            ->paginate(30)
            ->withQueryString();
        $vehicleMakes = VehicleMake::query()->orderBy('name')->get(['id', 'name']);
        $vehicleModels = VehicleModel::query()->with('make:id,name')
            ->when($makeId, fn (Builder $query) => $query->where('vehicle_make_id', $makeId))
            ->orderBy('name')
            ->get(['id', 'name', 'vehicle_make_id']);

        return view('admin.vehicles.quality-without-fitments', compact('configurations', 'vehicleMakes', 'vehicleModels', 'makeId', 'modelId'));
    }
}

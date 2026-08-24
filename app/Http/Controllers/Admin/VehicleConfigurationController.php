<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleConfigurationRequest;
use App\Models\VehicleBodyStyle;
use App\Models\VehicleConfiguration;
use App\Models\VehicleGeneration;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleRoofType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleConfigurationController extends Controller
{
    public function index(Request $request, VehicleMake $vehicleMake, VehicleModel $vehicleModel, VehicleGeneration $vehicleGeneration): View
    {
        $this->ensureRelated($vehicleMake, $vehicleModel, $vehicleGeneration);
        $vehicleConfigurations = $vehicleGeneration->configurations()->with(['bodyStyle', 'roofType'])
            ->when($request->string('search')->isNotEmpty(), fn ($query) => $query->where('display_name', 'like', '%'.$request->string('search').'%'))
            ->paginate(30)->withQueryString();

        return view('admin.vehicles.vehicle-configurations.index', compact('vehicleMake', 'vehicleModel', 'vehicleGeneration', 'vehicleConfigurations'));
    }

    public function create(VehicleMake $vehicleMake, VehicleModel $vehicleModel, VehicleGeneration $vehicleGeneration): View
    {
        $this->ensureRelated($vehicleMake, $vehicleModel, $vehicleGeneration);
        $nextSortOrder = ((int) $vehicleGeneration->configurations()->max('sort_order')) + 1;

        return view('admin.vehicles.vehicle-configurations.create', [...$this->formData(), ...compact('vehicleMake', 'vehicleModel', 'vehicleGeneration', 'nextSortOrder')]);
    }

    public function store(VehicleConfigurationRequest $request, VehicleMake $vehicleMake, VehicleModel $vehicleModel, VehicleGeneration $vehicleGeneration): RedirectResponse
    {
        $this->ensureRelated($vehicleMake, $vehicleModel, $vehicleGeneration);
        $configuration = $vehicleGeneration->configurations()->create($request->validated());

        return redirect()->route('admin.vehicles.vehicle-configurations.edit', [$vehicleMake, $vehicleModel, $vehicleGeneration, $configuration])->with('success', 'Конфигурация добавлена.');
    }

    public function edit(VehicleMake $vehicleMake, VehicleModel $vehicleModel, VehicleGeneration $vehicleGeneration, VehicleConfiguration $vehicleConfiguration): View
    {
        $this->ensureConfiguration($vehicleMake, $vehicleModel, $vehicleGeneration, $vehicleConfiguration);

        return view('admin.vehicles.vehicle-configurations.edit', [...$this->formData(), ...compact('vehicleMake', 'vehicleModel', 'vehicleGeneration', 'vehicleConfiguration')]);
    }

    public function update(VehicleConfigurationRequest $request, VehicleMake $vehicleMake, VehicleModel $vehicleModel, VehicleGeneration $vehicleGeneration, VehicleConfiguration $vehicleConfiguration): RedirectResponse
    {
        $this->ensureConfiguration($vehicleMake, $vehicleModel, $vehicleGeneration, $vehicleConfiguration);
        $vehicleConfiguration->update($request->validated());

        return back()->with('success', 'Конфигурация сохранена.');
    }

    public function destroy(VehicleMake $vehicleMake, VehicleModel $vehicleModel, VehicleGeneration $vehicleGeneration, VehicleConfiguration $vehicleConfiguration): RedirectResponse
    {
        $this->ensureConfiguration($vehicleMake, $vehicleModel, $vehicleGeneration, $vehicleConfiguration);
        $vehicleConfiguration->delete();

        return redirect()->route('admin.vehicles.vehicle-configurations.index', [$vehicleMake, $vehicleModel, $vehicleGeneration])->with('success', 'Конфигурация удалена.');
    }

    private function formData(): array
    {
        return [
            'vehicleBodyStyles' => VehicleBodyStyle::query()->orderBy('sort_order')->orderBy('name')->get(),
            'vehicleRoofTypes' => VehicleRoofType::query()->orderBy('sort_order')->orderBy('name')->get(),
        ];
    }

    private function ensureRelated(VehicleMake $make, VehicleModel $model, VehicleGeneration $generation): void
    {
        abort_unless($model->vehicle_make_id === $make->id && $generation->vehicle_model_id === $model->id, 404);
    }

    private function ensureConfiguration(VehicleMake $make, VehicleModel $model, VehicleGeneration $generation, VehicleConfiguration $configuration): void
    {
        $this->ensureRelated($make, $model, $generation);
        abort_unless($configuration->vehicle_generation_id === $generation->id, 404);
    }
}

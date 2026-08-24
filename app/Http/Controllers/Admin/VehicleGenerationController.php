<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleGenerationRequest;
use App\Models\VehicleGeneration;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Services\VehicleImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class VehicleGenerationController extends Controller
{
    public function __construct(private readonly VehicleImageService $imageService) {}

    public function index(Request $request, VehicleMake $vehicleMake, VehicleModel $vehicleModel): View
    {
        $this->ensureModel($vehicleMake, $vehicleModel);
        $vehicleGenerations = $vehicleModel->generations()->withCount('configurations')
            ->when($request->string('search')->isNotEmpty(), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->paginate(30)->withQueryString();

        return view('admin.vehicles.vehicle-generations.index', compact('vehicleMake', 'vehicleModel', 'vehicleGenerations'));
    }

    public function create(VehicleMake $vehicleMake, VehicleModel $vehicleModel): View
    {
        $this->ensureModel($vehicleMake, $vehicleModel);
        $nextSortOrder = ((int) $vehicleModel->generations()->max('sort_order')) + 1;

        return view('admin.vehicles.vehicle-generations.create', compact('vehicleMake', 'vehicleModel', 'nextSortOrder'));
    }

    public function store(VehicleGenerationRequest $request, VehicleMake $vehicleMake, VehicleModel $vehicleModel): RedirectResponse
    {
        $this->ensureModel($vehicleMake, $vehicleModel);
        $data = Arr::except($request->validated(), 'image');
        $data['image_path'] = $this->imageService->store($request->file('image'), 'vehicle-generations');
        $generation = $vehicleModel->generations()->create($data);

        return redirect()->route('admin.vehicles.vehicle-generations.edit', [$vehicleMake, $vehicleModel, $generation])->with('success', 'Поколение добавлено.');
    }

    public function edit(VehicleMake $vehicleMake, VehicleModel $vehicleModel, VehicleGeneration $vehicleGeneration): View
    {
        $this->ensureGeneration($vehicleMake, $vehicleModel, $vehicleGeneration);

        return view('admin.vehicles.vehicle-generations.edit', compact('vehicleMake', 'vehicleModel', 'vehicleGeneration'));
    }

    public function update(VehicleGenerationRequest $request, VehicleMake $vehicleMake, VehicleModel $vehicleModel, VehicleGeneration $vehicleGeneration): RedirectResponse
    {
        $this->ensureGeneration($vehicleMake, $vehicleModel, $vehicleGeneration);
        $data = Arr::except($request->validated(), 'image');
        $data['image_path'] = $this->imageService->store(
            $request->file('image'),
            'vehicle-generations',
            $vehicleGeneration->image_path,
        );
        $vehicleGeneration->update($data);

        return back()->with('success', 'Поколение сохранено.');
    }

    public function destroy(VehicleMake $vehicleMake, VehicleModel $vehicleModel, VehicleGeneration $vehicleGeneration): RedirectResponse
    {
        $this->ensureGeneration($vehicleMake, $vehicleModel, $vehicleGeneration);
        if ($vehicleGeneration->configurations()->exists()) {
            return back()->with('error', 'Сначала удалите конфигурации поколения.');
        }
        $this->imageService->delete($vehicleGeneration->image_path);
        $vehicleGeneration->delete();

        return redirect()->route('admin.vehicles.vehicle-generations.index', [$vehicleMake, $vehicleModel])->with('success', 'Поколение удалено.');
    }

    private function ensureModel(VehicleMake $make, VehicleModel $model): void
    {
        abort_unless($model->vehicle_make_id === $make->id, 404);
    }

    private function ensureGeneration(VehicleMake $make, VehicleModel $model, VehicleGeneration $generation): void
    {
        $this->ensureModel($make, $model);
        abort_unless($generation->vehicle_model_id === $model->id, 404);
    }
}

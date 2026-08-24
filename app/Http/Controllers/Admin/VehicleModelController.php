<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleModelRequest;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Services\VehicleImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class VehicleModelController extends Controller
{
    public function __construct(private VehicleImageService $images) {}

    public function index(Request $request, VehicleMake $vehicleMake): View
    {
        $vehicleModels = $vehicleMake->models()
            ->withCount('generations')
            ->when($request->string('search')->isNotEmpty(), function ($query) use ($request): void {
                $query->where(function ($query) use ($request): void {
                    $search = '%'.$request->string('search').'%';
                    $query->where('name', 'like', $search)->orWhere('slug', 'like', $search);
                });
            })
            ->paginate(30)
            ->withQueryString();

        return view('admin.vehicles.vehicle-models.index', compact('vehicleMake', 'vehicleModels'));
    }

    public function create(VehicleMake $vehicleMake): View
    {
        $nextSortOrder = ((int) $vehicleMake->models()->max('sort_order')) + 1;

        return view('admin.vehicles.vehicle-models.create', compact('vehicleMake', 'nextSortOrder'));
    }

    public function store(VehicleModelRequest $request, VehicleMake $vehicleMake): RedirectResponse
    {
        $data = $request->validated();
        $vehicleModel = $vehicleMake->models()->create([
            ...Arr::except($data, ['image']),
            'image_path' => $this->images->store($request->file('image'), 'vehicle-models'),
        ]);

        return redirect()
            ->route('admin.vehicles.vehicle-models.edit', [$vehicleMake, $vehicleModel])
            ->with('success', 'Модель автомобиля добавлена.');
    }

    public function edit(VehicleMake $vehicleMake, VehicleModel $vehicleModel): View
    {
        $this->ensureRelated($vehicleMake, $vehicleModel);
        $vehicleModel->load('generations');

        return view('admin.vehicles.vehicle-models.edit', compact('vehicleMake', 'vehicleModel'));
    }

    public function update(VehicleModelRequest $request, VehicleMake $vehicleMake, VehicleModel $vehicleModel): RedirectResponse
    {
        $this->ensureRelated($vehicleMake, $vehicleModel);
        $data = $request->validated();
        $vehicleModel->update([
            ...Arr::except($data, ['image']),
            'image_path' => $this->images->store(
                $request->file('image'),
                'vehicle-models',
                $vehicleModel->image_path,
            ),
        ]);

        return back()->with('success', 'Изменения модели сохранены.');
    }

    public function destroy(VehicleMake $vehicleMake, VehicleModel $vehicleModel): RedirectResponse
    {
        $this->ensureRelated($vehicleMake, $vehicleModel);
        $this->images->delete($vehicleModel->image_path);
        $vehicleModel->delete();

        return redirect()
            ->route('admin.vehicles.vehicle-models.index', $vehicleMake)
            ->with('success', 'Модель автомобиля удалена.');
    }

    private function ensureRelated(VehicleMake $vehicleMake, VehicleModel $vehicleModel): void
    {
        abort_unless($vehicleModel->vehicle_make_id === $vehicleMake->id, 404);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleRoofTypeRequest;
use App\Models\VehicleRoofType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleRoofTypeController extends Controller
{
    public function index(Request $request): View
    {
        $items = VehicleRoofType::query()->withCount('configurations')
            ->when($request->string('search')->isNotEmpty(), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->orderBy('sort_order')->orderBy('name')->paginate(30)->withQueryString();

        return view('admin.vehicles.lookups.index', [...$this->meta(), 'items' => $items]);
    }

    public function create(): View
    {
        $nextSortOrder = ((int) VehicleRoofType::query()->max('sort_order')) + 1;

        return view('admin.vehicles.lookups.create', [...$this->meta(), 'nextSortOrder' => $nextSortOrder]);
    }

    public function store(VehicleRoofTypeRequest $request): RedirectResponse
    {
        $item = VehicleRoofType::query()->create($request->validated());

        return redirect()->route('admin.vehicles.vehicle-roof-types.edit', $item)->with('success', 'Тип крыши добавлен.');
    }

    public function edit(VehicleRoofType $vehicleRoofType): View
    {
        return view('admin.vehicles.lookups.edit', [...$this->meta(), 'item' => $vehicleRoofType]);
    }

    public function update(VehicleRoofTypeRequest $request, VehicleRoofType $vehicleRoofType): RedirectResponse
    {
        $vehicleRoofType->update($request->validated());

        return back()->with('success', 'Тип крыши сохранён.');
    }

    public function destroy(VehicleRoofType $vehicleRoofType): RedirectResponse
    {
        if ($vehicleRoofType->configurations()->exists()) {
            return back()->with('error', 'Тип крыши используется в конфигурациях и не может быть удалён.');
        }
        $vehicleRoofType->delete();

        return redirect()->route('admin.vehicles.vehicle-roof-types.index')->with('success', 'Тип крыши удалён.');
    }

    private function meta(): array
    {
        return [
            'title' => 'Типы крыши', 'singular' => 'тип крыши', 'eyebrow' => 'Автомобильный справочник',
            'routePrefix' => 'admin.vehicles.vehicle-roof-types', 'routeParameter' => 'vehicle_roof_type',
        ];
    }
}

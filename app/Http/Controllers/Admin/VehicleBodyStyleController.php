<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleBodyStyleRequest;
use App\Models\VehicleBodyStyle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleBodyStyleController extends Controller
{
    public function index(Request $request): View
    {
        $items = VehicleBodyStyle::query()->withCount('configurations')
            ->when($request->string('search')->isNotEmpty(), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->orderBy('sort_order')->orderBy('name')->paginate(30)->withQueryString();

        return view('admin.vehicles.lookups.index', [...$this->meta(), 'items' => $items]);
    }

    public function create(): View
    {
        $nextSortOrder = ((int) VehicleBodyStyle::query()->max('sort_order')) + 1;

        return view('admin.vehicles.lookups.create', [...$this->meta(), 'nextSortOrder' => $nextSortOrder]);
    }

    public function store(VehicleBodyStyleRequest $request): RedirectResponse
    {
        $item = VehicleBodyStyle::query()->create($request->validated());

        return redirect()->route('admin.vehicles.vehicle-body-styles.edit', $item)->with('success', 'Тип кузова добавлен.');
    }

    public function edit(VehicleBodyStyle $vehicleBodyStyle): View
    {
        return view('admin.vehicles.lookups.edit', [...$this->meta(), 'item' => $vehicleBodyStyle]);
    }

    public function update(VehicleBodyStyleRequest $request, VehicleBodyStyle $vehicleBodyStyle): RedirectResponse
    {
        $vehicleBodyStyle->update($request->validated());

        return back()->with('success', 'Тип кузова сохранён.');
    }

    public function destroy(VehicleBodyStyle $vehicleBodyStyle): RedirectResponse
    {
        if ($vehicleBodyStyle->configurations()->exists()) {
            return back()->with('error', 'Тип кузова используется в конфигурациях и не может быть удалён.');
        }
        $vehicleBodyStyle->delete();

        return redirect()->route('admin.vehicles.vehicle-body-styles.index')->with('success', 'Тип кузова удалён.');
    }

    private function meta(): array
    {
        return [
            'title' => 'Типы кузова', 'singular' => 'тип кузова', 'eyebrow' => 'Автомобильный справочник',
            'routePrefix' => 'admin.vehicles.vehicle-body-styles', 'routeParameter' => 'vehicle_body_style',
        ];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BikeRackManufacturerRequest;
use App\Models\BikeRackManufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BikeRackManufacturerController extends Controller
{
    public function index(Request $request): View
    {
        $manufacturers = BikeRackManufacturer::query()->withCount('bikeRackProducts')
            ->when($request->string('search')->isNotEmpty(), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->orderBy('name')->paginate(40)->withQueryString();

        return view('admin.bike-rack-manufacturers.index', compact('manufacturers'));
    }

    public function create(): View
    {
        return view('admin.bike-rack-manufacturers.create');
    }

    public function store(BikeRackManufacturerRequest $request): RedirectResponse
    {
        $manufacturer = BikeRackManufacturer::query()->create($request->validated());

        return redirect()->route('admin.products.bike-racks.manufacturers.edit', $manufacturer)->with('success', 'Производитель добавлен.');
    }

    public function edit(BikeRackManufacturer $manufacturer): View
    {
        $manufacturer->loadCount('bikeRackProducts');

        return view('admin.bike-rack-manufacturers.edit', compact('manufacturer'));
    }

    public function update(BikeRackManufacturerRequest $request, BikeRackManufacturer $manufacturer): RedirectResponse
    {
        $manufacturer->update($request->validated());

        return back()->with('success', 'Изменения производителя сохранены.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoofRackManufacturerRequest;
use App\Models\RoofRackManufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoofRackManufacturerController extends Controller
{
    public function index(Request $request): View
    {
        $manufacturers = RoofRackManufacturer::query()
            ->withCount('roofRackProducts')
            ->when($request->string('search')->isNotEmpty(), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->orderBy('name')
            ->paginate(40)
            ->withQueryString();

        return view('admin.roof-rack-manufacturers.index', compact('manufacturers'));
    }

    public function create(): View
    {
        return view('admin.roof-rack-manufacturers.create');
    }

    public function store(RoofRackManufacturerRequest $request): RedirectResponse
    {
        $manufacturer = RoofRackManufacturer::query()->create($request->validated());

        return redirect()
            ->route('admin.products.roof-racks.manufacturers.edit', $manufacturer)
            ->with('success', 'Производитель добавлен.');
    }

    public function edit(RoofRackManufacturer $manufacturer): View
    {
        $manufacturer->loadCount('roofRackProducts');

        return view('admin.roof-rack-manufacturers.edit', compact('manufacturer'));
    }

    public function update(RoofRackManufacturerRequest $request, RoofRackManufacturer $manufacturer): RedirectResponse
    {
        $manufacturer->update($request->validated());

        return back()->with('success', 'Изменения производителя сохранены.');
    }
}

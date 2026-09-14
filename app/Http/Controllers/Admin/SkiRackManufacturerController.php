<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkiRackManufacturerRequest;
use App\Models\SkiRackManufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkiRackManufacturerController extends Controller
{
    public function index(Request $request): View
    {
        $manufacturers = SkiRackManufacturer::query()->withCount('skiRackProducts')->when($request->string('search')->isNotEmpty(), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))->orderBy('name')->paginate(40)->withQueryString();

        return view('admin.ski-rack-manufacturers.index', compact('manufacturers'));
    }

    public function create(): View
    {
        return view('admin.ski-rack-manufacturers.create');
    }

    public function store(SkiRackManufacturerRequest $request): RedirectResponse
    {
        $m = SkiRackManufacturer::query()->create($request->validated());

        return redirect()->route('admin.products.ski-racks.manufacturers.edit', $m)->with('success', 'Производитель добавлен.');
    }

    public function edit(SkiRackManufacturer $manufacturer): View
    {
        $manufacturer->loadCount('skiRackProducts');

        return view('admin.ski-rack-manufacturers.edit', compact('manufacturer'));
    }

    public function update(SkiRackManufacturerRequest $request, SkiRackManufacturer $manufacturer): RedirectResponse
    {
        $manufacturer->update($request->validated());

        return back()->with('success', 'Изменения производителя сохранены.');
    }
}

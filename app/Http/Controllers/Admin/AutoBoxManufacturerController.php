<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AutoBoxManufacturerRequest;
use App\Models\AutoBoxManufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AutoBoxManufacturerController extends Controller
{
    public function index(Request $request): View
    {
        $manufacturers = AutoBoxManufacturer::query()
            ->withCount('autoBoxProducts')
            ->when($request->string('search')->isNotEmpty(), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->orderBy('name')
            ->paginate(40)
            ->withQueryString();

        return view('admin.auto-box-manufacturers.index', compact('manufacturers'));
    }

    public function create(): View
    {
        return view('admin.auto-box-manufacturers.create');
    }

    public function store(AutoBoxManufacturerRequest $request): RedirectResponse
    {
        $manufacturer = AutoBoxManufacturer::query()->create($request->validated());

        return redirect()
            ->route('admin.products.auto-boxes.manufacturers.edit', $manufacturer)
            ->with('success', 'Производитель добавлен.');
    }

    public function edit(AutoBoxManufacturer $manufacturer): View
    {
        $manufacturer->loadCount('autoBoxProducts');

        return view('admin.auto-box-manufacturers.edit', compact('manufacturer'));
    }

    public function update(AutoBoxManufacturerRequest $request, AutoBoxManufacturer $manufacturer): RedirectResponse
    {
        $manufacturer->update($request->validated());

        return back()->with('success', 'Изменения производителя сохранены.');
    }
}

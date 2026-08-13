<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleMakeRequest;
use App\Models\CatalogCategory;
use App\Models\VehicleMake;
use App\Services\VehicleImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VehicleMakeController extends Controller
{
    public function __construct(private VehicleImageService $images) {}

    public function index(Request $request): View
    {
        $rootCategory = $this->rootCategory();
        $vehicleMakes = $rootCategory->vehicleMakes()
            ->withCount('models')
            ->when($request->string('search')->isNotEmpty(), function ($query) use ($request): void {
                $query->where(function ($query) use ($request): void {
                    $search = '%'.$request->string('search').'%';
                    $query->where('name', 'like', $search)->orWhere('slug', 'like', $search);
                });
            })
            ->orderByPivot('sort_order')
            ->orderBy('name')
            ->paginate(30)
            ->withQueryString();

        return view('admin.roof-racks.vehicle-makes.index', compact('rootCategory', 'vehicleMakes'));
    }

    public function create(): View
    {
        $rootCategory = $this->rootCategory();
        $nextSortOrder = ((int) $rootCategory->vehicleMakes()->max('catalog_category_vehicle_make.sort_order')) + 1;

        return view('admin.roof-racks.vehicle-makes.create', compact('nextSortOrder'));
    }

    public function attachForm(): View
    {
        $rootCategory = $this->rootCategory();
        $vehicleMakes = VehicleMake::query()
            ->whereDoesntHave('catalogCategories', fn ($query) => $query->whereKey($rootCategory->id))
            ->withCount('models')
            ->orderBy('name')
            ->get();
        $nextSortOrder = ((int) $rootCategory->vehicleMakes()->max('catalog_category_vehicle_make.sort_order')) + 1;

        return view('admin.roof-racks.vehicle-makes.attach', compact('vehicleMakes', 'nextSortOrder'));
    }

    public function attach(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'vehicle_make_id' => ['required', 'integer', Rule::exists('vehicle_makes', 'id')],
            'sort_order' => ['required', 'integer', 'min:0', 'max:4294967295'],
        ]);
        $rootCategory = $this->rootCategory();

        if ($rootCategory->vehicleMakes()->whereKey($data['vehicle_make_id'])->exists()) {
            return back()->withErrors(['vehicle_make_id' => 'Эта марка уже добавлена в раздел.']);
        }

        $rootCategory->vehicleMakes()->attach($data['vehicle_make_id'], [
            'sort_order' => $data['sort_order'],
        ]);

        return redirect()
            ->route('admin.roof-racks.vehicle-makes.edit', $data['vehicle_make_id'])
            ->with('success', 'Существующая марка привязана к разделу «Автобагажники».');
    }

    public function store(VehicleMakeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $rootCategory = $this->rootCategory();
        $vehicleMake = DB::transaction(function () use ($data, $request, $rootCategory): VehicleMake {
            $vehicleMake = VehicleMake::query()->create([
                ...Arr::except($data, ['image', 'sort_order']),
                'image_path' => $this->images->store($request->file('image'), 'vehicle-makes'),
            ]);

            $rootCategory->vehicleMakes()->attach($vehicleMake->id, [
                'sort_order' => $data['sort_order'],
            ]);

            return $vehicleMake;
        });

        return redirect()
            ->route('admin.roof-racks.vehicle-makes.edit', $vehicleMake)
            ->with('success', 'Марка добавлена в раздел «Автобагажники».');
    }

    public function edit(VehicleMake $vehicleMake): View
    {
        $rootCategory = $this->rootCategory();
        $rootCategory->vehicleMakes()->findOrFail($vehicleMake->id);
        $sortOrder = $vehicleMake->catalogCategories()->findOrFail($rootCategory->id)->pivot->sort_order;

        return view('admin.roof-racks.vehicle-makes.edit', compact('vehicleMake', 'sortOrder'));
    }

    public function update(VehicleMakeRequest $request, VehicleMake $vehicleMake): RedirectResponse
    {
        $rootCategory = $this->rootCategory();
        $rootCategory->vehicleMakes()->findOrFail($vehicleMake->id);
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $vehicleMake, $rootCategory): void {
            $vehicleMake->update([
                ...Arr::except($data, ['image', 'sort_order']),
                'image_path' => $this->images->store(
                    $request->file('image'),
                    'vehicle-makes',
                    $vehicleMake->image_path,
                ),
            ]);

            $rootCategory->vehicleMakes()->updateExistingPivot($vehicleMake->id, [
                'sort_order' => $data['sort_order'],
            ]);
        });

        return back()->with('success', 'Изменения марки сохранены.');
    }

    public function destroy(VehicleMake $vehicleMake): RedirectResponse
    {
        $this->rootCategory()->vehicleMakes()->detach($vehicleMake->id);

        return redirect()
            ->route('admin.roof-racks.vehicle-makes.index')
            ->with('success', 'Марка убрана из раздела «Автобагажники». Справочник марки сохранён.');
    }

    private function rootCategory(): CatalogCategory
    {
        return CatalogCategory::query()
            ->whereNull('parent_id')
            ->where('slug', 'autobagazhniki')
            ->firstOrFail();
    }
}

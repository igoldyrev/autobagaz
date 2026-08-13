<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleMakeRequest;
use App\Models\CatalogCategory;
use App\Models\VehicleMake;
use App\Services\VehicleImageService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VehicleMakeController extends Controller
{
    public function __construct(private VehicleImageService $images) {}

    public function index(Request $request): View
    {
        $vehicleMakes = VehicleMake::query()
            ->with(['catalogCategories' => fn ($query) => $query->orderBy('name')])
            ->withCount('models')
            ->when($request->string('search')->isNotEmpty(), function ($query) use ($request): void {
                $query->where(function ($query) use ($request): void {
                    $search = '%'.$request->string('search').'%';
                    $query->where('name', 'like', $search)->orWhere('slug', 'like', $search);
                });
            })
            ->orderBy('name')
            ->paginate(30)
            ->withQueryString();

        return view('admin.vehicles.vehicle-makes.index', compact('vehicleMakes'));
    }

    public function create(): View
    {
        $catalogSections = $this->catalogSections();

        return view('admin.vehicles.vehicle-makes.create', compact('catalogSections'));
    }

    public function store(VehicleMakeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $vehicleMake = DB::transaction(function () use ($data, $request): VehicleMake {
            $vehicleMake = VehicleMake::query()->create([
                ...Arr::except($data, ['image', 'catalog_category_ids']),
                'image_path' => $this->images->store($request->file('image'), 'vehicle-makes'),
            ]);

            $this->syncCatalogSections($vehicleMake, $data['catalog_category_ids'] ?? []);

            return $vehicleMake;
        });

        return redirect()
            ->route('admin.vehicles.vehicle-makes.edit', $vehicleMake)
            ->with('success', 'Марка добавлена в глобальный справочник.');
    }

    public function edit(VehicleMake $vehicleMake): View
    {
        $vehicleMake->load('catalogCategories');
        $catalogSections = $this->catalogSections();

        return view('admin.vehicles.vehicle-makes.edit', compact('vehicleMake', 'catalogSections'));
    }

    public function update(VehicleMakeRequest $request, VehicleMake $vehicleMake): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $vehicleMake): void {
            $vehicleMake->update([
                ...Arr::except($data, ['image', 'catalog_category_ids']),
                'image_path' => $this->images->store(
                    $request->file('image'),
                    'vehicle-makes',
                    $vehicleMake->image_path,
                ),
            ]);

            $this->syncCatalogSections($vehicleMake, $data['catalog_category_ids'] ?? []);
        });

        return back()->with('success', 'Изменения марки сохранены.');
    }

    private function catalogSections(): Collection
    {
        return CatalogCategory::query()
            ->whereNull('parent_id')
            ->where('kind', 'section')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    private function syncCatalogSections(VehicleMake $vehicleMake, array $sectionIds): void
    {
        $existingSortOrders = $vehicleMake->catalogCategories()
            ->pluck('catalog_category_vehicle_make.sort_order', 'catalog_categories.id');
        $syncData = [];

        foreach ($sectionIds as $sectionId) {
            $syncData[$sectionId] = [
                'sort_order' => $existingSortOrders->get($sectionId)
                    ?? ((int) DB::table('catalog_category_vehicle_make')
                        ->where('catalog_category_id', $sectionId)
                        ->max('sort_order')) + 1,
            ];
        }

        $vehicleMake->catalogCategories()->sync($syncData);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FitmentRequest;
use App\Models\Fitment;
use App\Models\Product;
use App\Models\RoofRackManufacturer;
use App\Models\VehicleBodyStyle;
use App\Models\VehicleConfiguration;
use App\Models\VehicleGeneration;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleRoofType;
use App\Services\VehicleCatalogService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FitmentController extends Controller
{
    public function index(Request $request): View
    {
        $fitments = Fitment::query()
            ->with('manufacturer')
            ->withCount(['configurations', 'products'])
            ->when($request->string('search')->isNotEmpty(), function (Builder $query) use ($request): void {
                $search = '%'.$request->string('search').'%';
                $query->where(fn (Builder $query) => $query->where('name', 'like', $search)->orWhere('code', 'like', $search));
            })
            ->orderBy('name')->paginate(30)->withQueryString();

        return view('admin.fitments.index', compact('fitments'));
    }

    public function create(): View
    {
        return view('admin.fitments.create', $this->formData());
    }

    public function store(FitmentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $fitment = Fitment::query()->create([
            ...Arr::except($data, ['product_ids']),
            'verified_at' => $data['verification_status'] === 'verified' ? now() : null,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);
        $this->syncProducts($fitment, $data['product_ids']);

        return redirect()->route('admin.fitments.edit', $fitment)->with('success', 'Группа применяемости добавлена. Теперь настройте автомобили.');
    }

    public function edit(Fitment $fitment): View
    {
        $fitment->load(['products', 'manufacturer'])->loadCount('configurations');

        return view('admin.fitments.edit', [...$this->formData(), 'fitment' => $fitment]);
    }

    public function update(FitmentRequest $request, Fitment $fitment): RedirectResponse
    {
        $data = $request->validated();
        $fitment->update([
            ...Arr::except($data, ['product_ids']),
            'verified_at' => $data['verification_status'] === 'verified' ? ($fitment->verified_at ?: now()) : null,
            'updated_by' => $request->user()->id,
        ]);
        $this->syncProducts($fitment, $data['product_ids']);

        return back()->with('success', 'Группа применяемости сохранена.');
    }

    public function destroy(Fitment $fitment): RedirectResponse
    {
        if ($fitment->configurations()->exists() || $fitment->products()->exists()) {
            return back()->with('error', 'Сначала удалите автомобили и товары из группы применяемости.');
        }
        $fitment->delete();

        return redirect()->route('admin.fitments.index')->with('success', 'Группа применяемости удалена.');
    }

    public function configurations(Request $request, Fitment $fitment): View
    {
        $query = VehicleConfiguration::query()->with(['bodyStyle', 'roofType', 'generation.vehicleModel.make']);
        $this->applyConfigurationFilters($query, $request);
        $configurations = $query->orderBy('display_name')->paginate(100)->withQueryString();
        $selectedConfigurations = $fitment->configurations()->get()->keyBy('id');
        $selectedIds = $selectedConfigurations->keys()->map(fn ($id): int => (int) $id)->all();

        return view('admin.fitments.configurations', [
            ...$this->configurationFilterData($request),
            ...compact('fitment', 'configurations', 'selectedIds', 'selectedConfigurations'),
        ]);
    }

    public function updateConfigurations(Request $request, Fitment $fitment): RedirectResponse
    {
        $data = $request->validate([
            'action' => ['required', Rule::in(['add', 'remove', 'save_parameters'])],
            'configuration_ids' => ['required', 'array', 'min:1', 'max:500'],
            'configuration_ids.*' => ['integer', 'distinct', Rule::exists('vehicle_configurations', 'id')],
            'parameters' => ['array'],
            'parameters.*.crossbar_spacing_min_mm' => ['nullable', 'integer', 'min:1', 'max:5000'],
            'parameters.*.crossbar_spacing_max_mm' => ['nullable', 'integer', 'min:1', 'max:5000'],
            'parameters.*.max_dynamic_load_kg' => ['nullable', 'numeric', 'min:0', 'max:9999.9'],
        ]);
        $ids = array_map('intval', $data['configuration_ids']);
        if ($data['action'] === 'add') {
            $fitment->configurations()->syncWithoutDetaching($ids);
            $message = 'Добавлено конфигураций: '.count($ids).'.';
        } elseif ($data['action'] === 'remove') {
            $fitment->configurations()->detach($ids);
            $message = 'Удалено конфигураций: '.count($ids).'.';
        } else {
            $attachedIds = $fitment->configurations()->whereKey($ids)->pluck('vehicle_configurations.id')->map(fn ($id): int => (int) $id)->all();
            foreach ($attachedIds as $id) {
                $parameters = $data['parameters'][$id] ?? [];
                $min = $parameters['crossbar_spacing_min_mm'] ?? null;
                $max = $parameters['crossbar_spacing_max_mm'] ?? null;
                if ($min !== null && $max !== null && (int) $max < (int) $min) {
                    return back()->withErrors(['parameters' => 'Максимальное расстояние между дугами не может быть меньше минимального.'])->withInput();
                }
                $fitment->configurations()->updateExistingPivot($id, [
                    'crossbar_spacing_min_mm' => $min,
                    'crossbar_spacing_max_mm' => $max,
                    'max_dynamic_load_kg' => $parameters['max_dynamic_load_kg'] ?? null,
                ]);
            }
            $message = 'Монтажные параметры сохранены: '.count($attachedIds).'.';
        }
        $fitment->update(['updated_by' => $request->user()->id]);

        return back()->with('success', $message);
    }

    public function preview(Fitment $fitment): View
    {
        $fitment->load(['manufacturer', 'products.roofRack.manufacturer', 'configurations.bodyStyle', 'configurations.roofType', 'configurations.generation.vehicleModel.make']);
        $groups = $fitment->configurations
            ->groupBy(fn (VehicleConfiguration $configuration): string => $configuration->generation->vehicleModel->make->name)
            ->map(fn ($makeConfigurations) => $makeConfigurations->groupBy(fn (VehicleConfiguration $configuration): string => $configuration->generation->vehicleModel->name));

        return view('admin.fitments.preview', compact('fitment', 'groups'));
    }

    private function formData(): array
    {
        return [
            'manufacturers' => RoofRackManufacturer::query()->orderBy('name')->get(),
            'roofRackProducts' => Product::query()->whereHas('roofRack')->with('roofRack.manufacturer')->orderBy('name')->get(),
        ];
    }

    /** @param array<int|string> $productIds */
    private function syncProducts(Fitment $fitment, array $productIds): void
    {
        $values = collect($productIds)->mapWithKeys(fn ($id): array => [(int) $id => ['status' => 'active']])->all();
        $fitment->products()->sync($values);
        VehicleCatalogService::invalidate();
    }

    private function applyConfigurationFilters(Builder $query, Request $request): void
    {
        $query
            ->when($request->filled('make_id'), fn (Builder $query) => $query->whereHas('generation.vehicleModel', fn (Builder $models) => $models->where('vehicle_make_id', $request->integer('make_id'))))
            ->when($request->filled('model_id'), fn (Builder $query) => $query->whereHas('generation', fn (Builder $generations) => $generations->where('vehicle_model_id', $request->integer('model_id'))))
            ->when($request->filled('generation_id'), fn (Builder $query) => $query->where('vehicle_generation_id', $request->integer('generation_id')))
            ->when($request->filled('body_style_id'), fn (Builder $query) => $query->where('vehicle_body_style_id', $request->integer('body_style_id')))
            ->when($request->filled('roof_type_id'), fn (Builder $query) => $query->where('vehicle_roof_type_id', $request->integer('roof_type_id')))
            ->when($request->string('search')->isNotEmpty(), fn (Builder $query) => $query->where('display_name', 'like', '%'.$request->string('search').'%'));
    }

    private function configurationFilterData(Request $request): array
    {
        return [
            'vehicleMakes' => VehicleMake::query()->orderBy('name')->get(['id', 'name']),
            'vehicleModels' => $request->filled('make_id') ? VehicleModel::query()->where('vehicle_make_id', $request->integer('make_id'))->orderBy('name')->get(['id', 'name']) : collect(),
            'vehicleGenerations' => $request->filled('model_id') ? VehicleGeneration::query()->where('vehicle_model_id', $request->integer('model_id'))->orderBy('sort_order')->get(['id', 'name']) : collect(),
            'vehicleBodyStyles' => VehicleBodyStyle::query()->orderBy('name')->get(['id', 'name']),
            'vehicleRoofTypes' => VehicleRoofType::query()->orderBy('name')->get(['id', 'name']),
        ];
    }
}

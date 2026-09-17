<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompatibilityOverrideRequest;
use App\Models\CompatibilityOverride;
use App\Models\Fitment;
use App\Models\Product;
use App\Models\VehicleConfiguration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompatibilityOverrideController extends Controller
{
    public function index(Request $request): View
    {
        $overrides = CompatibilityOverride::query()
            ->with(['vehicleConfiguration.generation.vehicleModel.make', 'fitment', 'baseProduct', 'accessoryProduct'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->string('quality')->value() === 'conflicts', function ($query): void {
                $conflictIds = CompatibilityOverride::query()->effective()
                    ->get(['id', 'vehicle_configuration_id', 'fitment_id', 'base_product_id', 'accessory_product_id', 'priority', 'status'])
                    ->groupBy(fn (CompatibilityOverride $override) => implode(':', [
                        $override->vehicle_configuration_id ?? 'all-vehicles', $override->fitment_id ?? 'all-fitments',
                        $override->base_product_id, $override->accessory_product_id ?? 'no-accessory', $override->priority,
                    ]))
                    ->filter(fn ($group) => $group->pluck('status')->unique()->count() > 1)
                    ->flatMap(fn ($group) => $group->pluck('id'));

                $query->whereKey($conflictIds);
            })
            ->latest()->paginate(30)->withQueryString();

        return view('admin.compatibility-overrides.index', compact('overrides'));
    }

    public function create(): View
    {
        return view('admin.compatibility-overrides.create', $this->formData());
    }

    public function store(CompatibilityOverrideRequest $request): RedirectResponse
    {
        $override = CompatibilityOverride::query()->create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('admin.compatibility-overrides.edit', $override)->with('success', 'Исключение добавлено.');
    }

    public function edit(CompatibilityOverride $compatibilityOverride): View
    {
        return view('admin.compatibility-overrides.edit', [...$this->formData(), 'compatibilityOverride' => $compatibilityOverride]);
    }

    public function update(CompatibilityOverrideRequest $request, CompatibilityOverride $compatibilityOverride): RedirectResponse
    {
        $compatibilityOverride->update([...$request->validated(), 'updated_by' => $request->user()->id]);

        return back()->with('success', 'Исключение сохранено.');
    }

    public function destroy(CompatibilityOverride $compatibilityOverride): RedirectResponse
    {
        $compatibilityOverride->delete();

        return redirect()->route('admin.compatibility-overrides.index')->with('success', 'Исключение удалено.');
    }

    private function formData(): array
    {
        return [
            'vehicleConfigurations' => VehicleConfiguration::query()->with('generation.vehicleModel.make')->get()->sortBy(fn ($configuration) => $configuration->generation->vehicleModel->make->name.' '.$configuration->generation->vehicleModel->name.' '.$configuration->display_name),
            'fitments' => Fitment::query()->orderBy('name')->get(),
            'baseProducts' => Product::query()->whereHas('roofRack')->orderBy('name')->get(),
            'accessoryProducts' => Product::query()->whereHas('autoBox')->orderBy('name')->get(),
        ];
    }
}

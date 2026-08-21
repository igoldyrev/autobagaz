<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\VehicleBodyType;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class VehicleFitmentController extends Controller
{
    public function index(Request $request): View
    {
        $vehicleMakes = VehicleMake::query()->active()->orderBy('name')->get(['id', 'name']);
        $make = $this->selectedMake($request);
        $model = $this->selectedModel($request, $make);
        $bodyType = $this->selectedBodyType($request, $model);

        $baseProducts = collect();
        $dependentProducts = collect();

        if ($model && $bodyType) {
            $baseProducts = $this->compatibleBaseProducts($model, $bodyType);
            $dependentProducts = $this->compatibleDependentProducts($baseProducts);
        }

        return view('catalog.vehicle-fitment.index', compact(
            'vehicleMakes',
            'make',
            'model',
            'bodyType',
            'baseProducts',
            'dependentProducts',
        ));
    }

    public function models(Request $request): JsonResponse
    {
        $make = VehicleMake::query()->active()->findOrFail($request->integer('make_id'));

        return response()->json($make->models()->active()->get(['id', 'name']));
    }

    public function bodyTypes(Request $request): JsonResponse
    {
        $model = VehicleModel::query()->active()->findOrFail($request->integer('model_id'));

        return response()->json($model->bodyTypes()->active()->get(['id', 'name', 'source_name', 'year_label', 'mounting_type']));
    }

    private function selectedMake(Request $request): ?VehicleMake
    {
        return $request->filled('make_id')
            ? VehicleMake::query()->active()->findOrFail($request->integer('make_id'))
            : null;
    }

    private function selectedModel(Request $request, ?VehicleMake $make): ?VehicleModel
    {
        if (! $make || ! $request->filled('model_id')) {
            return null;
        }

        return $make->models()->active()->findOrFail($request->integer('model_id'));
    }

    private function selectedBodyType(Request $request, ?VehicleModel $model): ?VehicleBodyType
    {
        if (! $model || ! $request->filled('body_type_id')) {
            return null;
        }

        return $model->bodyTypes()->active()->findOrFail($request->integer('body_type_id'));
    }

    /** @return Collection<int, Product> */
    private function compatibleBaseProducts(VehicleModel $model, VehicleBodyType $bodyType): Collection
    {
        return Product::query()
            ->active()
            ->whereHas('roofRack')
            ->where(function (Builder $query) use ($model, $bodyType): void {
                $query->whereHas('vehicleModels', fn (Builder $models) => $models->whereKey($model->id))
                    ->orWhereHas('vehicleBodyTypes', fn (Builder $bodyTypes) => $bodyTypes->whereKey($bodyType->id));
            })
            ->with(['images', 'roofRack.manufacturer'])
            ->orderBy('name')
            ->get();
    }

    /** @param Collection<int, Product> $baseProducts
     *  @return Collection<int, Product>
     */
    private function compatibleDependentProducts(Collection $baseProducts): Collection
    {
        if ($baseProducts->isEmpty()) {
            return collect();
        }

        return Product::query()
            ->active()
            ->whereHas('autoBox')
            ->whereHas('baseProducts', fn (Builder $baseProductsQuery) => $baseProductsQuery
                ->whereIn('product_base_product.base_product_id', $baseProducts->modelKeys())
                ->where('product_base_product.compatibility_type', 'via_base_product'))
            ->with(['images', 'autoBox.manufacturer', 'categories'])
            ->orderBy('name')
            ->get();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\VehicleConfiguration;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Services\VehicleCatalogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleFitmentController extends Controller
{
    public function index(Request $request, VehicleCatalogService $catalog): View
    {
        $vehicleMakes = $this->vehicleMakes();
        $selectedVehicle = $request->attributes->get('vehicleConfiguration');
        $selectedVehicleYear = $request->attributes->get('vehicleYear');
        $baseProducts = collect();
        $dependentProducts = collect();
        $bikeRackProducts = collect();
        $skiRackProducts = collect();
        $categoryResults = collect();

        if ($selectedVehicle) {
            $summary = $catalog->summary($selectedVehicle);
            $roofRackIds = $summary['roof_rack_ids'];
            $autoBoxIds = $summary['auto_box_ids'];
            $bikeRackIds = $summary['bike_rack_ids'];
            $skiRackIds = $summary['ski_rack_ids'];
            $baseProducts = Product::query()
                ->whereKey($roofRackIds)
                ->with(['images', 'roofRack.manufacturer'])
                ->orderBy('name')
                ->get();
            $dependentProducts = Product::query()
                ->whereKey($autoBoxIds)
                ->with(['images', 'autoBox.manufacturer', 'categories'])
                ->orderBy('name')
                ->get();
            $bikeRackProducts = Product::query()
                ->whereKey($bikeRackIds)
                ->with(['images', 'bikeRack.manufacturer'])
                ->orderBy('name')
                ->get();
            $skiRackProducts = Product::query()
                ->whereKey($skiRackIds)
                ->with(['images', 'skiRack.manufacturer'])
                ->orderBy('name')
                ->get();
            $categoryResults = collect([
                [
                    'name' => 'Багажники',
                    'count' => $summary['roof_rack_count'],
                    'url' => route('catalog.autobagazhniki.index', array_filter([
                        'vehicle_configuration_id' => $selectedVehicle->id,
                        'vehicle_year' => $selectedVehicleYear,
                    ])),
                ],
                [
                    'name' => 'Автобоксы',
                    'count' => $summary['auto_box_count'],
                    'url' => route('catalog.auto-boxes.index', array_filter([
                        'vehicle_configuration_id' => $selectedVehicle->id,
                        'vehicle_year' => $selectedVehicleYear,
                    ])),
                ],
                [
                    'name' => 'Велокрепления',
                    'count' => $summary['bike_rack_count'],
                    'url' => route('catalog.bike-racks.index', array_filter([
                        'vehicle_configuration_id' => $selectedVehicle->id,
                        'vehicle_year' => $selectedVehicleYear,
                    ])),
                ],
                [
                    'name' => 'Крепления для лыж и сноубордов',
                    'count' => $summary['ski_rack_count'],
                    'url' => route('catalog.ski-racks.index', array_filter([
                        'vehicle_configuration_id' => $selectedVehicle->id,
                        'vehicle_year' => $selectedVehicleYear,
                    ])),
                ],
            ]);
        }

        return view('catalog.vehicle-fitment.index', compact(
            'vehicleMakes',
            'selectedVehicle',
            'selectedVehicleYear',
            'baseProducts',
            'dependentProducts',
            'bikeRackProducts',
            'skiRackProducts',
            'categoryResults',
        ));
    }

    public function models(Request $request): JsonResponse
    {
        $make = VehicleMake::query()->active()->findOrFail($request->integer('make_id'));

        return response()->json($make->models()
            ->active()
            ->get(['id', 'name']));
    }

    public function configurations(Request $request): JsonResponse
    {
        $model = VehicleModel::query()->active()->findOrFail($request->integer('model_id'));

        $configurations = VehicleConfiguration::query()
            ->active()
            ->whereHas('generation', fn ($query) => $query
                ->active()
                ->where('vehicle_model_id', $model->id))
            ->with(['generation:id,vehicle_model_id,name,year_from,year_to', 'bodyStyle:id,name', 'roofType:id,name'])
            ->orderBy('sort_order')
            ->orderBy('display_name')
            ->get()
            ->map(function (VehicleConfiguration $configuration): array {
                $bodyworkLabel = $this->bodyworkLabel($configuration);

                return [
                    'id' => $configuration->id,
                    'display_name' => $configuration->display_name,
                    'year_from' => $configuration->year_from ?: $configuration->generation->year_from,
                    'year_to' => $configuration->year_to ?: $configuration->generation->year_to,
                    'generation' => [
                        'id' => $configuration->generation->id,
                        'name' => $configuration->generation->display_name,
                    ],
                    'body_style' => $configuration->bodyStyle
                        ? ['id' => $configuration->bodyStyle->id, 'name' => $configuration->bodyStyle->name]
                        : null,
                    'roof_type' => $configuration->roofType
                        ? ['id' => $configuration->roofType->id, 'name' => $configuration->roofType->name]
                        : null,
                    'bodywork' => [
                        'key' => mb_strtolower($bodyworkLabel),
                        'label' => $bodyworkLabel,
                    ],
                    'mounting' => [
                        'label' => $this->mountingLabel($configuration),
                    ],
                ];
            });

        return response()->json($configurations);
    }

    private function vehicleMakes()
    {
        return VehicleMake::query()
            ->active()
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function bodyworkLabel(VehicleConfiguration $configuration): string
    {
        $body = $configuration->bodyStyle?->name ?: $configuration->display_name;
        if ($configuration->doors_count) {
            $body .= ', '.$configuration->doors_count.' дв.';
        }

        return $body.' — '.$configuration->year_label;
    }

    private function mountingLabel(VehicleConfiguration $configuration): string
    {
        return $configuration->roofType?->name ?: 'Крепление не указано';
    }
}

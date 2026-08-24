<?php

namespace App\Services;

use App\Compatibility\CompatibilityContext;
use App\Compatibility\CompatibilityResult;
use App\Models\CompatibilityOverride;
use App\Models\Fitment;
use App\Models\Product;
use App\Models\VehicleConfiguration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CompatibilityService
{
    public function check(Product $product, CompatibilityContext $context): CompatibilityResult
    {
        $product->loadMissing(['productType', 'roofRack', 'autoBox']);
        $strategy = $product->productType?->compatibility_strategy
            ?? ($product->roofRack ? 'vehicle_fitment' : ($product->autoBox ? 'technical' : 'universal'));

        return match ($strategy) {
            'vehicle_fitment' => $this->checkVehicleFitment($product, $context->vehicleConfiguration),
            'technical' => $context->baseProduct
                ? $this->checkTechnicalPair($product, $context->baseProduct, $context->vehicleConfiguration)
                : $this->checkAgainstAvailableBases($product, $context->vehicleConfiguration),
            'universal' => new CompatibilityResult(CompatibilityResult::COMPATIBLE, ['Товар имеет универсальную стратегию совместимости.']),
            default => new CompatibilityResult(CompatibilityResult::UNKNOWN, ['Неизвестная стратегия совместимости.'], ['product_type.compatibility_strategy']),
        };
    }

    private function checkVehicleFitment(Product $baseProduct, VehicleConfiguration $vehicle): CompatibilityResult
    {
        $fitments = $this->matchingFitments($baseProduct, $vehicle);
        $override = $this->override($baseProduct, null, $vehicle, $fitments->modelKeys());
        if ($override) {
            return $this->overrideResult($override, $baseProduct->id);
        }

        if ($fitments->isEmpty()) {
            return new CompatibilityResult(
                CompatibilityResult::INCOMPATIBLE,
                ['Товар не связан с Fitment выбранной конфигурации автомобиля.'],
            );
        }

        return new CompatibilityResult(
            CompatibilityResult::COMPATIBLE,
            ['Подходит по Fitment: '.$fitments->pluck('code')->implode(', ').'.'],
            matchedBaseProductId: $baseProduct->id,
        );
    }

    private function checkAgainstAvailableBases(Product $accessory, VehicleConfiguration $vehicle): CompatibilityResult
    {
        $bases = Product::query()->active()->whereHas('roofRack')
            ->whereHas('fitments', fn (Builder $query) => $query->active()->where('fitment_product.status', 'active')->whereHas('configurations', fn (Builder $configurations) => $configurations->whereKey($vehicle->id)))
            ->with(['productType', 'roofRack', 'fitments'])
            ->get();

        if ($bases->isEmpty()) {
            return new CompatibilityResult(CompatibilityResult::INCOMPATIBLE, ['Для автомобиля не найдено ни одной подходящей базовой багажной системы.']);
        }

        $unknown = [];
        $incompatible = [];
        foreach ($bases as $base) {
            $result = $this->checkTechnicalPair($accessory, $base, $vehicle);
            if ($result->status === CompatibilityResult::COMPATIBLE) {
                return new CompatibilityResult(
                    CompatibilityResult::COMPATIBLE,
                    ['Совместимо через базовый товар «'.$base->name.'».', ...$result->reasons],
                    $result->missingData,
                    $base->id,
                    $result->appliedOverrideId,
                );
            }
            if ($result->status === CompatibilityResult::UNKNOWN) {
                $unknown[] = '«'.$base->name.'»: '.implode(' ', $result->reasons);
            } else {
                $incompatible[] = '«'.$base->name.'»: '.implode(' ', $result->reasons);
            }
        }

        if ($unknown !== []) {
            return new CompatibilityResult(
                CompatibilityResult::UNKNOWN,
                ['Ни одна база не подтверждена; для части вариантов недостаточно данных.', ...$unknown],
            );
        }

        return new CompatibilityResult(CompatibilityResult::INCOMPATIBLE, ['Ни одна подходящая багажная система не удовлетворяет ограничениям аксессуара.', ...$incompatible]);
    }

    private function checkTechnicalPair(Product $accessory, Product $base, VehicleConfiguration $vehicle): CompatibilityResult
    {
        $base->loadMissing(['roofRack', 'productType']);
        $accessory->loadMissing(['autoBox', 'productType']);
        if (! $base->roofRack || ! $accessory->autoBox) {
            return new CompatibilityResult(CompatibilityResult::UNKNOWN, ['Для этой пары техническая проверка не определена.'], ['roof_rack_products / auto_box_products']);
        }

        $fitments = $this->matchingFitments($base, $vehicle);
        $direct = $this->checkVehicleFitment($base, $vehicle);
        if ($direct->status !== CompatibilityResult::COMPATIBLE) {
            return new CompatibilityResult($direct->status, ['Базовый товар не устанавливается на выбранный автомобиль.', ...$direct->reasons]);
        }

        $override = $this->override($base, $accessory, $vehicle, $fitments->modelKeys());
        if ($override) {
            return $this->overrideResult($override, $base->id);
        }

        $reasons = [];
        $missing = [];
        $failed = false;
        $rack = $base->roofRack;
        $box = $accessory->autoBox;

        if ($rack->bar_width_mm === null || $box->clamp_width_min_mm === null || $box->clamp_width_max_mm === null) {
            $missing[] = 'ширина профиля или допустимый диапазон крепления';
        } elseif ($rack->bar_width_mm < $box->clamp_width_min_mm || $rack->bar_width_mm > $box->clamp_width_max_mm) {
            $failed = true;
            $reasons[] = 'Ширина дуги '.$rack->bar_width_mm.' мм не входит в диапазон '.$box->clamp_width_min_mm.'–'.$box->clamp_width_max_mm.' мм.';
        } else {
            $reasons[] = 'Ширина дуги '.$rack->bar_width_mm.' мм входит в допустимый диапазон.';
        }

        if ($rack->bar_height_mm === null || $box->clamp_height_max_mm === null) {
            $missing[] = 'высота профиля или максимальная высота крепления';
        } elseif ($rack->bar_height_mm > $box->clamp_height_max_mm) {
            $failed = true;
            $reasons[] = 'Высота дуги '.$rack->bar_height_mm.' мм превышает допустимые '.$box->clamp_height_max_mm.' мм.';
        } else {
            $reasons[] = 'Высота дуги '.$rack->bar_height_mm.' мм допустима.';
        }

        if ($box->required_t_slot_width_mm !== null) {
            if ($rack->t_slot_width_mm === null) {
                $missing[] = 'ширина T-паза';
            } elseif ($rack->t_slot_width_mm < $box->required_t_slot_width_mm) {
                $failed = true;
                $reasons[] = 'T-паз '.$rack->t_slot_width_mm.' мм уже требуемых '.$box->required_t_slot_width_mm.' мм.';
            } else {
                $reasons[] = 'T-паз удовлетворяет требованию '.$box->required_t_slot_width_mm.' мм.';
            }
        }

        $spacingResult = $this->checkSpacing($fitments, $vehicle, $box->crossbar_spacing_min_mm, $box->crossbar_spacing_max_mm);
        $reasons = [...$reasons, ...$spacingResult['reasons']];
        $missing = [...$missing, ...$spacingResult['missing']];
        $failed = $failed || $spacingResult['failed'];

        if ($failed) {
            return new CompatibilityResult(CompatibilityResult::INCOMPATIBLE, $reasons, array_values(array_unique($missing)), $base->id);
        }
        if ($missing !== []) {
            return new CompatibilityResult(
                CompatibilityResult::UNKNOWN,
                [...$reasons, 'Недостаточно данных для подтверждения совместимости.'],
                array_values(array_unique($missing)),
                $base->id,
            );
        }

        return new CompatibilityResult(CompatibilityResult::COMPATIBLE, $reasons, matchedBaseProductId: $base->id);
    }

    /** @return array{reasons: array<int, string>, missing: array<int, string>, failed: bool} */
    private function checkSpacing(Collection $fitments, VehicleConfiguration $vehicle, ?int $boxMin, ?int $boxMax): array
    {
        if ($boxMin === null || $boxMax === null) {
            return ['reasons' => [], 'missing' => ['допустимое расстояние между дугами для аксессуара'], 'failed' => false];
        }

        $knownRanges = [];
        foreach ($fitments as $fitment) {
            $configuration = $fitment->relationLoaded('configurations')
                ? $fitment->configurations->firstWhere('id', $vehicle->id)
                : $fitment->configurations()->whereKey($vehicle->id)->first();
            $min = $configuration?->pivot?->crossbar_spacing_min_mm;
            $max = $configuration?->pivot?->crossbar_spacing_max_mm;
            if ($min === null || $max === null) {
                continue;
            }
            $knownRanges[] = [$min, $max, $fitment->code];
            if (max($min, $boxMin) <= min($max, $boxMax)) {
                return [
                    'reasons' => ['Диапазон установки дуг '.$min.'–'.$max.' мм пересекается с допустимым для аксессуара '.$boxMin.'–'.$boxMax.' мм ('.$fitment->code.').'],
                    'missing' => [], 'failed' => false,
                ];
            }
        }

        if ($knownRanges === []) {
            return ['reasons' => [], 'missing' => ['расстояние между дугами для Fitment автомобиля'], 'failed' => false];
        }

        return [
            'reasons' => ['Ни один диапазон установки дуг автомобиля не пересекается с допустимым диапазоном аксессуара '.$boxMin.'–'.$boxMax.' мм.'],
            'missing' => [], 'failed' => true,
        ];
    }

    /** @return Collection<int, Fitment> */
    private function matchingFitments(Product $base, VehicleConfiguration $vehicle): Collection
    {
        if ($base->relationLoaded('fitments')) {
            return $base->fitments
                ->filter(fn (Fitment $fitment): bool => $fitment->is_active
                    && $fitment->pivot?->status === 'active'
                    && ($fitment->relationLoaded('configurations')
                        ? $fitment->configurations->contains('id', $vehicle->id)
                        : $fitment->configurations()->whereKey($vehicle->id)->exists()))
                ->values();
        }

        return $base->fitments()->active()
            ->wherePivot('status', 'active')
            ->whereHas('configurations', fn (Builder $query) => $query->whereKey($vehicle->id))
            ->get();
    }

    /** @param array<int> $fitmentIds */
    private function override(Product $base, ?Product $accessory, VehicleConfiguration $vehicle, array $fitmentIds): ?CompatibilityOverride
    {
        return CompatibilityOverride::query()->effective()
            ->where('base_product_id', $base->id)
            ->when($accessory, fn (Builder $query) => $query->where('accessory_product_id', $accessory->id), fn (Builder $query) => $query->whereNull('accessory_product_id'))
            ->where(fn (Builder $query) => $query->whereNull('vehicle_configuration_id')->orWhere('vehicle_configuration_id', $vehicle->id))
            ->where(function (Builder $query) use ($fitmentIds): void {
                $query->whereNull('fitment_id');
                if ($fitmentIds !== []) {
                    $query->orWhereIn('fitment_id', $fitmentIds);
                }
            })
            ->orderByRaw('vehicle_configuration_id IS NOT NULL DESC')
            ->orderByRaw('fitment_id IS NOT NULL DESC')
            ->orderByDesc('priority')
            ->orderByDesc('id')
            ->first();
    }

    private function overrideResult(CompatibilityOverride $override, ?int $baseProductId = null): CompatibilityResult
    {
        return new CompatibilityResult(
            $override->status,
            ['Применено ручное исключение: '.$override->reason],
            matchedBaseProductId: $baseProductId,
            appliedOverrideId: $override->id,
        );
    }
}

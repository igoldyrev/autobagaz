<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CatalogProductFilter
{
    use Concerns\SortsCatalogProducts;

    /** @return array<string, mixed> */
    public function values(Request $request): array
    {
        return [
            'sort' => $this->sort($request->input('sort')),
            'manufacturers' => $this->numbers($request->input('manufacturer')),
            'price_from' => $this->number($request->input('price_from')),
            'price_to' => $this->number($request->input('price_to')),
            'availability' => array_values(array_intersect(
                $this->strings($request->input('availability')),
                ['in_stock', 'to_order'],
            )),
            'load_capacities' => $this->numbers($request->input('load_capacity')),
            'bar_types' => $this->strings($request->input('bar_type')),
            'bar_lengths' => $this->numbers($request->input('bar_length')),
        ];
    }

    /** @param array<string, mixed> $filters */
    public function apply(Builder $query, array $filters): Builder
    {
        $query
            ->when($filters['manufacturers'] !== [], fn (Builder $query) => $query->whereHas(
                'roofRack',
                fn (Builder $query) => $query->whereIn('manufacturer_id', $filters['manufacturers']),
            ))
            ->when($filters['price_from'] !== null, fn (Builder $query) => $query->where('price', '>=', $filters['price_from']))
            ->when($filters['price_to'] !== null, fn (Builder $query) => $query->where('price', '<=', $filters['price_to']));

        if (count($filters['availability']) === 1) {
            $filters['availability'][0] === 'in_stock'
                ? $query->where('stock', '>', 0)
                : $query->where('stock', 0);
        }

        if ($filters['load_capacities'] !== [] || $filters['bar_types'] !== [] || $filters['bar_lengths'] !== []) {
            $query->whereHas('roofRack', function (Builder $query) use ($filters): void {
                $query
                    ->when($filters['load_capacities'] !== [], fn (Builder $query) => $query->whereIn('load_capacity_kg', $filters['load_capacities']))
                    ->when($filters['bar_types'] !== [], fn (Builder $query) => $query->whereIn('bar_type', $filters['bar_types']))
                    ->when($filters['bar_lengths'] !== [], fn (Builder $query) => $query->whereIn('bar_length_cm', $filters['bar_lengths']));
            });
        }

        return $query;
    }

    /**
     * @param  Collection<int, Product>  $products
     * @return array<string, mixed>
     */
    public function options(Collection $products): array
    {
        $roofRacks = $products->pluck('roofRack')->filter();

        return [
            'manufacturers' => $roofRacks->pluck('manufacturer')->filter(fn ($manufacturer) => $manufacturer?->is_active)->unique('id')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->values(),
            'price_min' => $products->min('price'),
            'price_max' => $products->max('price'),
            'load_capacities' => $roofRacks->pluck('load_capacity_kg')->filter(fn ($value) => $value !== null)->unique()->sort(SORT_NUMERIC)->values(),
            'bar_types' => $roofRacks->pluck('bar_type')->filter(fn ($value) => filled($value))->unique()->sort(SORT_NATURAL | SORT_FLAG_CASE)->values(),
            'bar_lengths' => $roofRacks->pluck('bar_length_cm')->filter(fn ($value) => $value !== null)->unique()->sort(SORT_NUMERIC)->values(),
        ];
    }

    /** @return array<int, string> */
    private function strings(mixed $value): array
    {
        return collect(is_array($value) ? $value : ($value === null ? [] : [$value]))
            ->filter(fn ($item) => is_string($item) || is_numeric($item))
            ->map(fn ($item): string => trim((string) $item))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /** @return array<int, string> */
    private function numbers(mixed $value): array
    {
        return collect($this->strings($value))
            ->filter(fn (string $item): bool => is_numeric($item) && (float) $item >= 0)
            ->values()
            ->all();
    }

    private function number(mixed $value): ?string
    {
        return is_scalar($value) && is_numeric($value) && (float) $value >= 0
            ? (string) $value
            : null;
    }
}

<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BikeRackProductFilter
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
            'availability' => array_values(array_intersect($this->strings($request->input('availability')), ['in_stock', 'to_order'])),
            'mounting_types' => $this->strings($request->input('mounting_type')),
            'bike_capacities' => $this->numbers($request->input('bike_capacity')),
            'load_capacities' => $this->numbers($request->input('load_capacity')),
        ];
    }

    /** @param array<string, mixed> $filters */
    public function apply(Builder $query, array $filters): Builder
    {
        $query->when($filters['price_from'] !== null, fn (Builder $query) => $query->where('price', '>=', $filters['price_from']))
            ->when($filters['price_to'] !== null, fn (Builder $query) => $query->where('price', '<=', $filters['price_to']));

        if (count($filters['availability']) === 1) {
            $filters['availability'][0] === 'in_stock' ? $query->where('stock', '>', 0) : $query->where('stock', 0);
        }

        $query->whereHas('bikeRack', function (Builder $query) use ($filters): void {
            $query->when($filters['manufacturers'] !== [], fn (Builder $query) => $query->whereIn('manufacturer_id', $filters['manufacturers']))
                ->when($filters['mounting_types'] !== [], fn (Builder $query) => $query->whereIn('mounting_type', $filters['mounting_types']))
                ->when($filters['bike_capacities'] !== [], fn (Builder $query) => $query->whereIn('bike_capacity', $filters['bike_capacities']))
                ->when($filters['load_capacities'] !== [], fn (Builder $query) => $query->whereIn('load_capacity_kg', $filters['load_capacities']));
        });

        return $query;
    }

    /** @param Collection<int, Product> $products @return array<string, mixed> */
    public function options(Collection $products): array
    {
        $bikeRacks = $products->pluck('bikeRack')->filter();

        return [
            'manufacturers' => $bikeRacks->pluck('manufacturer')->filter(fn ($manufacturer) => $manufacturer?->is_active)->unique('id')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->values(),
            'price_min' => $products->min('price'),
            'price_max' => $products->max('price'),
            'mounting_types' => $this->stringOptions($bikeRacks, 'mounting_type'),
            'bike_capacities' => $this->numericOptions($bikeRacks, 'bike_capacity'),
            'load_capacities' => $this->numericOptions($bikeRacks, 'load_capacity_kg'),
        ];
    }

    private function numericOptions(Collection $items, string $field): Collection
    {
        return $items->pluck($field)->filter(fn ($value) => $value !== null)->unique()->sort(SORT_NUMERIC)->values();
    }

    private function stringOptions(Collection $items, string $field): Collection
    {
        return $items->pluck($field)->filter(fn ($value) => filled($value))->unique()->sort(SORT_NATURAL | SORT_FLAG_CASE)->values();
    }

    /** @return array<int, string> */
    private function strings(mixed $value): array
    {
        return collect(is_array($value) ? $value : ($value === null ? [] : [$value]))->filter(fn ($item) => is_string($item) || is_numeric($item))->map(fn ($item): string => trim((string) $item))->filter()->unique()->values()->all();
    }

    /** @return array<int, string> */
    private function numbers(mixed $value): array
    {
        return collect($this->strings($value))->filter(fn (string $item): bool => is_numeric($item) && (float) $item >= 0)->values()->all();
    }

    private function number(mixed $value): ?string
    {
        return is_scalar($value) && is_numeric($value) && (float) $value >= 0 ? (string) $value : null;
    }
}

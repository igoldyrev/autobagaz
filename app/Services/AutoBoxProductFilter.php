<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AutoBoxProductFilter
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
            'lengths' => $this->numbers($request->input('length')),
            'widths' => $this->numbers($request->input('width')),
            'heights' => $this->numbers($request->input('height')),
            'volumes' => $this->numbers($request->input('volume')),
            'load_capacities' => $this->numbers($request->input('load_capacity')),
            'opening_types' => $this->strings($request->input('opening_type')),
            'mounting_types' => $this->strings($request->input('mounting_type')),
            'colors' => $this->strings($request->input('box_color')),
        ];
    }

    /** @param array<string, mixed> $filters */
    public function apply(Builder $query, array $filters): Builder
    {
        $query
            ->when($filters['price_from'] !== null, fn (Builder $query) => $query->where('price', '>=', $filters['price_from']))
            ->when($filters['price_to'] !== null, fn (Builder $query) => $query->where('price', '<=', $filters['price_to']));

        if (count($filters['availability']) === 1) {
            $filters['availability'][0] === 'in_stock'
                ? $query->where('stock', '>', 0)
                : $query->where('stock', 0);
        }

        $query->whereHas('autoBox', function (Builder $query) use ($filters): void {
            $query
                ->when($filters['manufacturers'] !== [], fn (Builder $query) => $query->whereIn('manufacturer_id', $filters['manufacturers']))
                ->when($filters['lengths'] !== [], fn (Builder $query) => $query->whereIn('length_cm', $filters['lengths']))
                ->when($filters['widths'] !== [], fn (Builder $query) => $query->whereIn('width_cm', $filters['widths']))
                ->when($filters['heights'] !== [], fn (Builder $query) => $query->whereIn('height_cm', $filters['heights']))
                ->when($filters['volumes'] !== [], fn (Builder $query) => $query->whereIn('volume_l', $filters['volumes']))
                ->when($filters['load_capacities'] !== [], fn (Builder $query) => $query->whereIn('load_capacity_kg', $filters['load_capacities']))
                ->when($filters['opening_types'] !== [], fn (Builder $query) => $query->whereIn('opening_type', $filters['opening_types']))
                ->when($filters['mounting_types'] !== [], fn (Builder $query) => $query->whereIn('mounting_type', $filters['mounting_types']))
                ->when($filters['colors'] !== [], fn (Builder $query) => $query->whereIn('box_color', $filters['colors']));
        });

        return $query;
    }

    /**
     * @param  Collection<int, Product>  $products
     * @return array<string, mixed>
     */
    public function options(Collection $products): array
    {
        $autoBoxes = $products->pluck('autoBox')->filter();

        return [
            'manufacturers' => $autoBoxes->pluck('manufacturer')->filter(fn ($manufacturer) => $manufacturer?->is_active)->unique('id')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->values(),
            'price_min' => $products->min('price'),
            'price_max' => $products->max('price'),
            'lengths' => $this->numericOptions($autoBoxes, 'length_cm'),
            'widths' => $this->numericOptions($autoBoxes, 'width_cm'),
            'heights' => $this->numericOptions($autoBoxes, 'height_cm'),
            'volumes' => $this->numericOptions($autoBoxes, 'volume_l'),
            'load_capacities' => $this->numericOptions($autoBoxes, 'load_capacity_kg'),
            'opening_types' => $this->stringOptions($autoBoxes, 'opening_type'),
            'mounting_types' => $this->stringOptions($autoBoxes, 'mounting_type'),
            'colors' => $this->stringOptions($autoBoxes, 'box_color'),
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
        return is_scalar($value) && is_numeric($value) && (float) $value >= 0 ? (string) $value : null;
    }
}

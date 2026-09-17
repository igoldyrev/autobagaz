<?php

namespace App\Services\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait SortsCatalogProducts
{
    /** @param array<string, mixed> $filters */
    public function applySorting(Builder $query, array $filters): Builder
    {
        return match ($filters['sort']) {
            'price_asc' => $query->orderBy('price')->orderBy('name'),
            'price_desc' => $query->orderByDesc('price')->orderBy('name'),
            'in_stock' => $query->orderByRaw('case when stock > 0 then 0 else 1 end')->orderByDesc('catalog_priority')->orderBy('name'),
            default => $query->orderByDesc('catalog_priority')->orderBy('name'),
        };
    }

    private function sort(mixed $value): string
    {
        return in_array($value, ['popular', 'price_asc', 'price_desc', 'in_stock'], true) ? $value : 'popular';
    }
}

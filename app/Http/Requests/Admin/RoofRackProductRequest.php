<?php

namespace App\Http\Requests\Admin;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Validation\Rule;

class RoofRackProductRequest extends ProductRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['manufacturer']);
        $currentManufacturerId = $this->route('product')?->roofRack?->manufacturer_id;

        return [
            ...$rules,
            'manufacturer_id' => [
                'nullable',
                'integer',
                Rule::exists('roof_rack_manufacturers', 'id')->where(function (QueryBuilder $query) use ($currentManufacturerId): void {
                    $query->where('is_active', true);

                    if ($currentManufacturerId) {
                        $query->orWhere('id', $currentManufacturerId);
                    }
                }),
            ],
            'bar_length_cm' => ['nullable', 'numeric', 'min:0', 'max:99999.9'],
            'load_capacity_kg' => ['nullable', 'numeric', 'min:0', 'max:99999.9'],
            'installation_method' => ['nullable', 'string', 'max:255'],
            'bar_type' => ['nullable', 'string', 'max:255'],
            'rack_color' => ['nullable', 'string', 'max:255'],
            'compatibility_product_ids' => ['array'],
            'compatibility_product_ids.*' => [
                'integer',
                'distinct',
                Rule::exists('products', 'id')->where(fn (QueryBuilder $query) => $query->whereExists(function (QueryBuilder $autoBox) {
                    $autoBox->selectRaw('1')
                        ->from('auto_box_products')
                        ->whereColumn('auto_box_products.product_id', 'products.id');
                })),
            ],
        ];
    }
}

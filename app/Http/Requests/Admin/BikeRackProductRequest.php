<?php

namespace App\Http\Requests\Admin;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Validation\Rule;

class BikeRackProductRequest extends ProductRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['manufacturer'], $rules['category_ids'], $rules['category_ids.*']);
        $currentManufacturerId = $this->route('product')?->bikeRack?->manufacturer_id;

        return [
            ...$rules,
            'manufacturer_id' => [
                'nullable', 'integer',
                Rule::exists('bike_rack_manufacturers', 'id')->where(function (QueryBuilder $query) use ($currentManufacturerId): void {
                    $query->where('is_active', true);
                    if ($currentManufacturerId) {
                        $query->orWhere('id', $currentManufacturerId);
                    }
                }),
            ],
            'mounting_type' => ['nullable', Rule::in(['На крышу', 'На фаркоп', 'На заднюю дверь'])],
            'bike_capacity' => ['nullable', 'integer', 'min:1', 'max:10'],
            'load_capacity_kg' => ['nullable', 'numeric', 'min:0', 'max:99999.9'],
        ];
    }
}

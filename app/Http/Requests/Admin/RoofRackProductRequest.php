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
            'bar_length_mm' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'bar_width_mm' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'bar_height_mm' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'profile_type' => ['nullable', Rule::in(['rectangular', 'aerodynamic', 'wing', 'other'])],
            't_slot_width_mm' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}

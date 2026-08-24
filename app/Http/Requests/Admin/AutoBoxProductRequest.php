<?php

namespace App\Http\Requests\Admin;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Validation\Rule;

class AutoBoxProductRequest extends ProductRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['manufacturer'], $rules['category_ids'], $rules['category_ids.*']);
        $currentManufacturerId = $this->route('product')?->autoBox?->manufacturer_id;

        return [
            ...$rules,
            'manufacturer_id' => [
                'nullable',
                'integer',
                Rule::exists('auto_box_manufacturers', 'id')->where(function (QueryBuilder $query) use ($currentManufacturerId): void {
                    $query->where('is_active', true);

                    if ($currentManufacturerId) {
                        $query->orWhere('id', $currentManufacturerId);
                    }
                }),
            ],
            'length_cm' => ['nullable', 'numeric', 'min:0', 'max:999999.9'],
            'width_cm' => ['nullable', 'numeric', 'min:0', 'max:999999.9'],
            'height_cm' => ['nullable', 'numeric', 'min:0', 'max:999999.9'],
            'volume_l' => ['nullable', 'numeric', 'min:0', 'max:999999.9'],
            'load_capacity_kg' => ['nullable', 'numeric', 'min:0', 'max:99999.9'],
            'opening_type' => ['nullable', Rule::in(['Одностороннее', 'Двухстороннее'])],
            'mounting_type' => ['nullable', Rule::in(['U-скоба', 'Быстросъем', 'Лапа быстросъем'])],
            'box_color' => ['nullable', Rule::in([
                'Белый глянец',
                'Белый карбон',
                'Белый матовый',
                'Серый глянец',
                'Серый карбон',
                'Серый матовый',
                'Черный глянец',
                'Черный карбон',
                'Черный матовый',
            ])],
            'clamp_width_min_mm' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'clamp_width_max_mm' => ['nullable', 'integer', 'min:1', 'max:1000', 'gte:clamp_width_min_mm'],
            'clamp_height_max_mm' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'crossbar_spacing_min_mm' => ['nullable', 'integer', 'min:1', 'max:5000'],
            'crossbar_spacing_max_mm' => ['nullable', 'integer', 'min:1', 'max:5000', 'gte:crossbar_spacing_min_mm'],
            'required_t_slot_width_mm' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'clamp_width_max_mm.gte' => 'Значение поля «Ширина дуги до, мм» должно быть не меньше :value.',
            'crossbar_spacing_max_mm.gte' => 'Значение поля «Расстояние между дугами до, мм» должно быть не меньше :value.',
        ];
    }
}

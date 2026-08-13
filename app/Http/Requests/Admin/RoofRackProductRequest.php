<?php

namespace App\Http\Requests\Admin;

class RoofRackProductRequest extends ProductRequest
{
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'bar_length_cm' => ['nullable', 'numeric', 'min:0', 'max:99999.9'],
            'load_capacity_kg' => ['nullable', 'numeric', 'min:0', 'max:99999.9'],
            'installation_method' => ['nullable', 'string', 'max:255'],
            'bar_type' => ['nullable', 'string', 'max:255'],
            'rack_color' => ['nullable', 'string', 'max:255'],
        ];
    }
}

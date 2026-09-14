<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BikeRackManufacturerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['name' => Str::squish($this->input('name')), 'is_active' => $this->boolean('is_active')]);
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:255', Rule::unique('bike_rack_manufacturers', 'name')->ignore($this->route('manufacturer'))], 'is_active' => ['boolean']];
    }
}

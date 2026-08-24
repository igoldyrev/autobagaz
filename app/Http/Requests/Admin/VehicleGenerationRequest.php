<?php

namespace App\Http\Requests\Admin;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VehicleGenerationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('name')),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required', 'string', 'max:255', 'alpha_dash:ascii',
                Rule::unique('vehicle_generations', 'slug')
                    ->where(fn (Builder $query): Builder => $query->where('vehicle_model_id', $this->route('vehicle_model')->id))
                    ->ignore($this->route('vehicle_generation')),
            ],
            'year_from' => ['nullable', 'integer', 'min:1885', 'max:2200'],
            'year_to' => ['nullable', 'integer', 'min:1885', 'max:2200', 'gte:year_from'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'is_active' => ['boolean'],
        ];
    }
}

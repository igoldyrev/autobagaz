<?php

namespace App\Http\Requests\Admin;

use App\Models\VehicleConfiguration;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VehicleConfigurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('display_name')),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function rules(): array
    {
        return [
            'display_name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required', 'string', 'max:255', 'alpha_dash:ascii',
                Rule::unique('vehicle_configurations', 'slug')
                    ->where(fn (Builder $query): Builder => $query->where('vehicle_generation_id', $this->route('vehicle_generation')->id))
                    ->ignore($this->route('vehicle_configuration')),
            ],
            'vehicle_body_style_id' => ['nullable', 'integer', Rule::exists('vehicle_body_styles', 'id')],
            'vehicle_roof_type_id' => ['nullable', 'integer', Rule::exists('vehicle_roof_types', 'id')],
            'year_from' => ['nullable', 'integer', 'min:1885', 'max:2200'],
            'year_to' => ['nullable', 'integer', 'min:1885', 'max:2200', 'gte:year_from'],
            'doors_count' => ['nullable', 'integer', 'min:1', 'max:9'],
            'verification_status' => ['required', Rule::in(VehicleConfiguration::VERIFICATION_STATUSES)],
            'notes' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'is_active' => ['boolean'],
        ];
    }
}

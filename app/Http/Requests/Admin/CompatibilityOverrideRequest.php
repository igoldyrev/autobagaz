<?php

namespace App\Http\Requests\Admin;

use App\Models\CompatibilityOverride;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompatibilityOverrideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }

    public function rules(): array
    {
        return [
            'vehicle_configuration_id' => ['nullable', 'integer', Rule::exists('vehicle_configurations', 'id')],
            'fitment_id' => ['nullable', 'integer', Rule::exists('fitments', 'id')],
            'base_product_id' => [
                'required', 'integer',
                Rule::exists('products', 'id')->where(fn (Builder $query) => $query->whereExists(function (Builder $roofRack): void {
                    $roofRack->selectRaw('1')->from('roof_rack_products')->whereColumn('roof_rack_products.product_id', 'products.id');
                })),
            ],
            'accessory_product_id' => [
                'nullable', 'integer', 'different:base_product_id',
                Rule::exists('products', 'id')->where(fn (Builder $query) => $query->whereExists(function (Builder $autoBox): void {
                    $autoBox->selectRaw('1')->from('auto_box_products')->whereColumn('auto_box_products.product_id', 'products.id');
                })),
            ],
            'status' => ['required', Rule::in(CompatibilityOverride::STATUSES)],
            'reason' => ['required', 'string', 'max:5000'],
            'source' => ['nullable', 'string', 'max:255'],
            'priority' => ['required', 'integer', 'min:-10000', 'max:10000'],
            'valid_from' => ['nullable', 'date'],
            'valid_to' => ['nullable', 'date', 'after_or_equal:valid_from'],
            'is_active' => ['boolean'],
        ];
    }
}

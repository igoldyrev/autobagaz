<?php

namespace App\Http\Requests\Admin;

use App\Models\Fitment;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FitmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $code = Str::upper(Str::slug((string) ($this->input('code') ?: $this->input('name'))));
        $this->merge([
            'code' => $code,
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:255', 'regex:/^[A-Z0-9][A-Z0-9-]*$/', Rule::unique('fitments')->ignore($this->route('fitment'))],
            'name' => ['required', 'string', 'max:255'],
            'roof_rack_manufacturer_id' => ['nullable', 'integer', Rule::exists('roof_rack_manufacturers', 'id')],
            'verification_status' => ['required', Rule::in(Fitment::VERIFICATION_STATUSES)],
            'notes' => ['nullable', 'string'],
            'product_ids' => ['array'],
            'product_ids.*' => [
                'integer', 'distinct',
                Rule::exists('products', 'id')->where(fn (Builder $query) => $query->whereExists(function (Builder $roofRack): void {
                    $roofRack->selectRaw('1')->from('roof_rack_products')->whereColumn('roof_rack_products.product_id', 'products.id');
                })),
            ],
            'is_active' => ['boolean'],
        ];
    }
}

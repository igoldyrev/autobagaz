<?php

namespace App\Http\Requests\Admin;

use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class SkiRackProductRequest extends ProductRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['manufacturer'],$rules['category_ids'],$rules['category_ids.*']);
        $current = $this->route('product')?->skiRack?->manufacturer_id;

        return [...$rules, 'manufacturer_id' => ['nullable', 'integer', Rule::exists('ski_rack_manufacturers', 'id')->where(function (Builder $query) use ($current): void {
            $query->where('is_active', true);
            if ($current) {
                $query->orWhere('id', $current);
            }
        })], 'ski_pairs_capacity' => ['nullable', 'integer', 'min:1', 'max:20'], 'snowboard_capacity' => ['nullable', 'integer', 'min:1', 'max:20']];
    }
}

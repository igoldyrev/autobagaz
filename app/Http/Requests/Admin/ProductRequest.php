<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Product;

class ProductRequest extends FormRequest
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
            'category_ids' => array_values(array_filter((array) $this->input('category_ids'))),
            'remove_image_ids' => array_values(array_filter((array) $this->input('remove_image_ids'))),
            'badges' => array_values(array_filter((array) $this->input('badges'))),
            'catalog_priority' => $this->integer('catalog_priority'),
        ]);
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash:ascii', Rule::unique('products', 'slug')->ignore($product)],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'country_of_origin' => ['nullable', 'string', 'max:255'],
            'product_model' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'is_active' => ['boolean'],
            'badges' => ['array', 'max:3'],
            'badges.*' => ['string', 'distinct', Rule::in(array_keys(Product::BADGES))],
            'catalog_priority' => ['integer', 'min:0', 'max:1000000'],
            'category_ids' => ['array'],
            'category_ids.*' => ['integer', 'distinct', 'exists:catalog_categories,id'],
            'images' => ['array', 'max:10'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:6144'],
            'remove_image_ids' => ['array'],
            'remove_image_ids.*' => ['integer', 'distinct'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $positioningBadges = array_intersect(
                (array) $this->input('badges'),
                Product::POSITIONING_BADGES,
            );

            if (count($positioningBadges) > 1) {
                $validator->errors()->add('badges', 'Можно выбрать только один позиционный бейдж: «Бюджетный», «Оптимальный» или «Премиум».');
            }
        });
    }
}

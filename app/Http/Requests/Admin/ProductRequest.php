<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        ]);
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash:ascii', Rule::unique('products', 'slug')->ignore($product)],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'country_of_origin' => ['nullable', 'string', 'max:255'],
            'product_model' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'is_active' => ['boolean'],
            'category_ids' => ['array'],
            'category_ids.*' => ['integer', 'distinct', 'exists:catalog_categories,id'],
            'images' => ['array', 'max:10'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:6144'],
            'remove_image_ids' => ['array'],
            'remove_image_ids.*' => ['integer', 'distinct'],
        ];
    }
}

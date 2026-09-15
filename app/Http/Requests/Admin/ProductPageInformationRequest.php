<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductPageInformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'delivery_content' => ['required', 'string', 'max:10000'],
            'payment_content' => ['required', 'string', 'max:10000'],
            'warranty_content' => ['required', 'string', 'max:10000'],
        ];
    }
}

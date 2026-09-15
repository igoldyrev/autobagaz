<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:32', 'regex:/^[0-9+()\\s-]{7,32}$/'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'delivery_method' => ['required', Rule::in(['pickup', 'delivery'])],
            'delivery_address' => ['nullable', 'string', 'max:500', 'required_if:delivery_method,delivery'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'delivery_address.required_if' => 'Укажите адрес доставки.',
            'phone.regex' => 'Введите номер телефона в корректном формате.',
        ];
    }
}

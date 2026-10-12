<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutOrderRequest extends FormRequest
{
    public const TOKEN_SESSION_KEY = 'checkout.token';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'checkout_token' => ['required', 'uuid', Rule::in([$this->session()->get(self::TOKEN_SESSION_KEY)])],
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
            'checkout_token.required' => 'Обновите страницу оформления заказа и попробуйте снова.',
            'checkout_token.uuid' => 'Обновите страницу оформления заказа и попробуйте снова.',
            'checkout_token.in' => 'Эта форма оформления устарела. Обновите страницу и попробуйте снова.',
            'delivery_address.required_if' => 'Укажите адрес доставки.',
            'phone.regex' => 'Введите номер телефона в корректном формате.',
        ];
    }
}

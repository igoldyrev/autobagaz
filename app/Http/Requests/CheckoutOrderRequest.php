<?php

namespace App\Http\Requests;

use App\Support\PersonalDataConsent;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use JsonException;

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
            'checkout_snapshot' => ['bail', 'required', 'string', 'max:65536', function (string $attribute, mixed $value, Closure $fail) {
                try {
                    $snapshot = json_decode(Crypt::decryptString($value), true, 512, JSON_THROW_ON_ERROR);
                    if (($snapshot['token'] ?? null) !== $this->input('checkout_token') || ! is_array($snapshot['items'] ?? null)) {
                        $fail('Обновите страницу оформления заказа и подтвердите состав и сумму.');
                    }
                } catch (DecryptException|JsonException $exception) {
                    $fail('Обновите страницу оформления заказа и подтвердите состав и сумму.');
                }
            }],
            'customer_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:32', 'regex:/^[0-9+()\\s-]{7,32}$/'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'delivery_method' => ['required', Rule::in(['pickup', 'delivery'])],
            'delivery_address' => ['nullable', 'string', 'max:500', 'required_if:delivery_method,delivery'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'personal_data_consent' => ['required', 'accepted'],
            'consent_version' => ['required', Rule::in([PersonalDataConsent::VERSION])],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'checkout_snapshot.required' => 'Обновите страницу оформления заказа и подтвердите состав и сумму.',
            'checkout_token.required' => 'Обновите страницу оформления заказа и попробуйте снова.',
            'checkout_token.uuid' => 'Обновите страницу оформления заказа и попробуйте снова.',
            'checkout_token.in' => 'Эта форма оформления устарела. Обновите страницу и попробуйте снова.',
            'delivery_address.required_if' => 'Укажите адрес доставки.',
            'personal_data_consent.required' => 'Подтвердите согласие на обработку персональных данных.',
            'personal_data_consent.accepted' => 'Подтвердите согласие на обработку персональных данных.',
            'consent_version.required' => 'Обновите страницу и подтвердите актуальную версию согласия.',
            'consent_version.in' => 'Текст согласия обновился. Обновите страницу и подтвердите новую версию.',
            'phone.regex' => 'Введите номер телефона в корректном формате.',
        ];
    }
}

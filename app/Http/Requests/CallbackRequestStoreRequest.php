<?php

namespace App\Http\Requests;

use App\Support\PersonalDataConsent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CallbackRequestStoreRequest extends FormRequest
{
    protected $errorBag = 'callback';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:32', 'regex:/^[0-9+()\\s-]{7,32}$/'],
            'personal_data_consent' => ['required', 'accepted'],
            'consent_version' => ['required', Rule::in([PersonalDataConsent::VERSION])],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'personal_data_consent.required' => 'Подтвердите согласие на обработку персональных данных.',
            'personal_data_consent.accepted' => 'Подтвердите согласие на обработку персональных данных.',
            'consent_version.required' => 'Обновите страницу и подтвердите актуальную версию согласия.',
            'consent_version.in' => 'Текст согласия обновился. Обновите страницу и подтвердите новую версию.',
            'phone.regex' => 'Введите номер телефона в корректном формате.',
        ];
    }
}

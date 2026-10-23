<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcceptOrderTermsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['version' => ['required', 'integer', 'min:1'], 'accept_terms' => ['required', 'accepted']];
    }

    protected function getRedirectUrl(): string
    {
        return $this->route('order')->customerUrl();
    }

    public function messages(): array
    {
        return ['accept_terms.required' => 'Подтвердите согласие с предложенными условиями.', 'accept_terms.accepted' => 'Подтвердите согласие с предложенными условиями.'];
    }
}

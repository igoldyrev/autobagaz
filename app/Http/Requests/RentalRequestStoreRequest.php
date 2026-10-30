<?php

namespace App\Http\Requests;

use App\Support\PersonalDataConsent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RentalRequestStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'submission_token' => ['required', 'uuid'],
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:32', 'regex:/^[0-9+()\\s-]{7,32}$/'],
            'group' => ['required', 'integer', 'between:0,1'],
            'quantity' => ['required', 'integer', 'between:1,100'],
            'starts_on' => ['required', 'date_format:Y-m-d', 'after_or_equal:'.now(config('app.display_timezone'))->toDateString()],
            'ends_on' => ['required', 'date_format:Y-m-d', 'after_or_equal:starts_on', 'before_or_equal:'.now(config('app.display_timezone'))->addYears(2)->toDateString()],
            'vehicle' => ['nullable', 'string', 'max:255'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'personal_data_consent' => ['required', 'accepted'],
            'consent_version' => ['required', Rule::in([PersonalDataConsent::VERSION])],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }
}

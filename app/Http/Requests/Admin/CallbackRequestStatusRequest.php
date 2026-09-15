<?php

namespace App\Http\Requests\Admin;

use App\Models\CallbackRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CallbackRequestStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['status' => ['required', Rule::in(array_keys(CallbackRequest::statusLabels()))]];
    }
}

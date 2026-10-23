<?php

namespace App\Http\Requests\Admin;

use App\Models\Order;
use App\Models\OrderTermsVersion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderTermsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'expected_version' => ['required', 'integer', 'min:0'],
            'expected_status' => ['required', Rule::in(array_keys(Order::statusLabels()))],
            'items' => ['required', 'array', 'min:1'],
            'items.*' => ['required', 'array:quantity,supply_terms'],
            'items.*.quantity' => ['required', 'integer', 'min:0'],
            'items.*.supply_terms' => ['nullable', 'string', 'max:1000'],
            'delivery_method' => ['required', Rule::in(['pickup', 'delivery'])],
            'delivery_address' => ['nullable', 'string', 'max:500', 'required_if:delivery_method,delivery'],
            'delivery_terms' => ['required', 'string', 'max:2000'],
            'delivery_cost' => ['nullable', 'regex:/\A[0-9]{1,10}(?:\.[0-9]{1,2})?\z/'],
            'payment_method' => ['required', Rule::in(array_keys(OrderTermsVersion::paymentMethods()))],
            'payment_terms' => ['required', 'string', 'max:2000'],
        ];
    }
}

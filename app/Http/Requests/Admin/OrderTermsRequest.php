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
            'items.*' => ['required', 'array:quantity,supply_terms,unit_price'],
            'items.*.quantity' => ['required', 'integer', 'min:0', 'max:100'],
            'items.*.unit_price' => ['sometimes', 'required', 'regex:/\A[0-9]{1,10}(?:\.[0-9]{1,2})?\z/'],
            'items.*.supply_terms' => ['nullable', 'string', 'max:1000'],
            'additional_items' => ['nullable', 'array', 'max:100'],
            'additional_items.*' => ['required', 'array:quantity,supply_terms,unit_price'],
            'additional_items.*.quantity' => ['required', 'integer', 'min:0', 'max:100'],
            'additional_items.*.unit_price' => ['required', 'regex:/\A[0-9]{1,10}(?:\.[0-9]{1,2})?\z/'],
            'additional_items.*.supply_terms' => ['nullable', 'string', 'max:1000'],
            'change_reason' => ['required', 'string', 'max:2000'],
            'delivery_method' => ['required', Rule::in(['pickup', 'delivery'])],
            'delivery_address' => ['nullable', 'string', 'max:500', 'required_if:delivery_method,delivery'],
            'delivery_terms' => ['required', 'string', 'max:2000'],
            'delivery_cost' => ['nullable', 'regex:/\A[0-9]{1,10}(?:\.[0-9]{1,2})?\z/'],
            'payment_method' => ['required', Rule::in(array_keys(OrderTermsVersion::paymentMethods()))],
            'payment_terms' => ['required', 'string', 'max:2000'],
        ];
    }
}

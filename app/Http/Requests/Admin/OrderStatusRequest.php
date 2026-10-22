<?php

namespace App\Http\Requests\Admin;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required_without:assignee_id', Rule::in(array_keys(Order::statusLabels()))],
            'expected_status' => ['required_with:status', Rule::in(array_keys(Order::statusLabels()))],
            'assignee_id' => ['required_without:status', 'integer', 'exists:users,id'],
        ];
    }
}

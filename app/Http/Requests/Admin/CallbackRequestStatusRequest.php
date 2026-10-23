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

    public function messages(): array
    {
        return [
            'internal_comment.required_without_all' => 'Введите внутренний комментарий.',
            'internal_comment.max' => 'Комментарий не должен превышать 2000 символов.',
            'cancellation_reason.required_if' => 'Укажите причину отмены.',
            'cancellation_reason.max' => 'Причина отмены не должна превышать 2000 символов.',
        ];
    }

    public function rules(): array
    {
        return [
            'status' => ['required_without_all:assignee_id,internal_comment', Rule::in(array_keys(CallbackRequest::statusLabels()))],
            'expected_status' => ['required_with:status', Rule::in(array_keys(CallbackRequest::statusLabels()))],
            'internal_comment' => ['required_without_all:status,assignee_id', 'nullable', 'string', 'max:2000'],
            'cancellation_reason' => ['required_if:status,cancelled', 'nullable', 'string', 'max:2000'],
            'assignee_id' => ['required_without_all:status,internal_comment', 'integer', 'exists:users,id'],
        ];
    }
}

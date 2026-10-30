<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RentalUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'deposit_type.required' => 'Выберите тип залога: деньги или документ.',
            'deposit_required.required' => 'Для денежного залога укажите сумму.',
            'deposit_required.gt' => 'Для денежного залога укажите сумму больше нуля. Если оставлен документ, выберите тип залога «Документ».',
            'deposit_document.required_if' => 'Укажите вид и описание документа, оставленного в залог.',
        ];
    }

    public function rules(): array
    {
        $action = $this->input('action');
        $money = ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:1000000000'];
        $rules = [
            'version' => ['required', 'integer', 'min:1'],
            'action' => ['required', Rule::in(['terms', 'assign', 'comment', 'contact', 'contact_failed', 'start', 'confirm', 'revise', 'issue', 'return_equipment', 'complete', 'cancel', 'purchase', 'receive_deposit', 'return_deposit', 'withhold_deposit', 'rental_payment', 'rental_refund', 'extend'])],
            'note' => [Rule::requiredIf(in_array($action, ['comment', 'contact', 'contact_failed', 'cancel', 'withhold_deposit'], true)), 'nullable', 'string', 'max:2000'],
        ];
        if ($action === 'terms') {
            $rules += [
                'equipment' => ['required', 'string', 'max:255'],
                'quantity' => ['required', 'integer', 'between:1,100'],
                'starts_on' => ['required', 'date_format:Y-m-d'],
                'ends_on' => ['required', 'date_format:Y-m-d', 'after_or_equal:starts_on'],
                'daily_price' => $money,
                'buyout_price' => $money,
                'deposit_type' => ['required', Rule::in(['money', 'document'])],
                'deposit_required' => ['exclude_unless:deposit_type,money', ...$money, 'gt:0'],
                'deposit_document' => ['exclude_unless:deposit_type,document', 'required_if:deposit_type,document', 'nullable', 'string', 'max:255'],
            ];
        }
        if ($action === 'assign') {
            $rules['assignee_id'] = ['required', 'integer', Rule::exists(User::class, 'id')];
        }
        if (in_array($action, ['receive_deposit', 'return_deposit', 'withhold_deposit', 'rental_payment', 'rental_refund'], true)) {
            $rules['amount'] = $money;
        }
        if ($action === 'extend') {
            $rules['ends_on'] = ['required', 'date_format:Y-m-d'];
            $rules['note'] = ['required', 'string', 'max:2000'];
        }
        if ($action === 'purchase') {
            $rules['buyout_paid'] = $money;
        }
        if (in_array($action, ['issue', 'return_equipment', 'purchase', 'receive_deposit', 'return_deposit', 'withhold_deposit', 'rental_payment', 'rental_refund'], true)) {
            $rules['confirmed'] = ['required', 'accepted'];
        }

        return $rules;
    }
}

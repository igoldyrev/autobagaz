<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RentalServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_available' => $this->boolean('is_available')]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'conditions' => ['required', 'string', 'max:5000'],
            'is_available' => ['boolean'],
            'groups' => ['required', 'array', 'size:2'],
            'groups.*' => ['required', 'string', 'max:255'],
            'rates' => ['required', 'array', 'size:3'],
            'rates.*.min_days' => ['required', 'integer', 'between:1,730'],
            'rates.*.max_days' => ['nullable', 'integer', 'between:1,730'],
            'rates.*.prices' => ['required', 'array', 'size:2'],
            'rates.*.prices.*' => ['required', 'decimal:0,2', 'numeric', 'min:0.01', 'max:1000000'],
            'contract' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'rules' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }
            $next = 1;
            foreach (array_values($this->input('rates')) as $i => $rate) {
                $max = $rate['max_days'] ?? null;
                if ((int) $rate['min_days'] !== $next || ($i < 2 && ($max === null || (int) $max < $next)) || ($i === 2 && $max !== null)) {
                    $validator->errors()->add('rates', 'Диапазоны должны идти подряд от 1 дня без пересечений; последний диапазон — без верхней границы.');

                    return;
                }
                $next = (int) $max + 1;
            }
        }];
    }
}

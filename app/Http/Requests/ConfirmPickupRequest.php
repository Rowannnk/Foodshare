<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConfirmPickupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('confirm', $this->route('pickup')) ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'pickup_code' => strtoupper(trim((string) $this->input('pickup_code'))),
        ]);
    }

    public function rules(): array
    {
        return [
            'pickup_code' => [
                'required',
                'string',
                'max:20',
                Rule::in([$this->route('pickup')->pickup_code]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'pickup_code.required' => 'Please type the pickup code.',
            'pickup_code.in' => 'This code does not match the pickup.',
        ];
    }
}
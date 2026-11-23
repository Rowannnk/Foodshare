<?php

namespace App\Http\Requests;

use App\Enums\OrganizationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $allowedTypes = array_map(
            fn (OrganizationType $type) => $type->value,
            OrganizationType::forRole($this->user()->role),
        );

        return [
            'name' => ['required', 'string', 'max:120'],
            'type' => ['required', Rule::in($allowedTypes)],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'This organization type is not allowed for your account.',
        ];
    }
}
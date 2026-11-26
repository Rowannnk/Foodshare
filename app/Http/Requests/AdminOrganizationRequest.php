<?php
namespace App\Http\Requests;

use App\Enums\OrganizationType;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $ownerRole = $this->input('type') === OrganizationType::CHARITY->value
            ? UserRole::RECIPIENT
            : UserRole::DONOR;

        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', $ownerRole->value),
            ],
            'name' => ['required', 'string', 'max:120'],
            'type' => [
                'required',
                Rule::in(array_map(
                    fn (OrganizationType $type) => $type->value,
                    OrganizationType::cases()
                )),
            ],
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
            'user_id.exists' => 'The selected owner does not have the correct account role for this organization type.',
        ];
    }
}

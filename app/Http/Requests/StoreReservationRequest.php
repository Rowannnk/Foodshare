<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isRecipient() ?? false;
    }

    public function rules(): array
    {
        $remaining = $this->route('foodListing')->remainingQuantity();

        return [
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$remaining],
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.max' => 'Only :max items are still available.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use App\Enums\ListingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FoodListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $user = $this->user();
        $isCreate = $this->isMethod('POST');

        $minQuantity = $isCreate
            ? 1
            : max(1, $this->route('foodListing')->reservedQuantity());

        $rules = [
            'organization_id' => [
                'required',
                'integer',
                Rule::exists('organizations', 'id')->where(
                    fn ($query) => $user->isAdmin() ? $query : $query->where('user_id', $user->id)
                ),
            ],
            'food_category_id' => [
                'required',
                'integer',
                Rule::exists('food_categories', 'id')->where('is_active', true),
            ],
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'photo' => $isCreate
                ? ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048']
                : ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'quantity' => ['required', 'integer', 'min:'.$minQuantity, 'max:1000'],
            'pickup_from' => $isCreate ? ['required', 'date', 'after:now'] : ['required', 'date'],
            'pickup_until' => ['required', 'date', 'after:pickup_from'],
            'expires_at' => ['required', 'date', 'after_or_equal:pickup_until'],
        ];

        if (! $isCreate) {
            $rules['status'] = ['required', Rule::enum(ListingStatus::class)];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'organization_id.required' => 'Please choose an organization.',
            'organization_id.exists' => 'You can only use your own organizations.',
            'food_category_id.required' => 'Please choose a category.',
            'photo.required' => 'Please upload a photo of the food.',
            'photo.image' => 'The file must be an image.',
            'photo.mimes' => 'The photo must be a JPG, PNG or WebP file.',
            'photo.max' => 'The photo may not be larger than 2 MB.',
            'photo.uploaded' => 'The photo could not be uploaded. Try a smaller file.',
            'quantity.min' => 'The quantity cannot be less than the :min items that are already reserved.',
            'pickup_until.after' => 'The pickup end time must be after the pickup start time.',
            'expires_at.after_or_equal' => 'The best before date cannot be earlier than the end of the pickup.',
        ];
    }
}

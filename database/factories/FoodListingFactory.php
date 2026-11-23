<?php

namespace Database\Factories;

use App\Enums\ListingStatus;
use App\Models\FoodCategory;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FoodListingFactory extends Factory
{
    public function definition(): array
    {
        $pickupFrom = Carbon::instance(
            fake()->dateTimeBetween('+1 hour', '+2 days')
        );

        return [
            'organization_id' => Organization::factory(),
            'food_category_id' => FoodCategory::factory(),
            'title' => fake()->randomElement([
                'Fresh bread rolls',
                'Mixed vegetables box',
                'Leftover pasta trays',
                'Milk and yogurt packs',
                'Sandwiches and wraps',
                'Fruit basket',
            ]),
            'description' => fake()->sentence(),
            'quantity' => fake()->numberBetween(1, 30),
            'pickup_from' => $pickupFrom,
            'pickup_until' => $pickupFrom->copy()->addHours(3),
            'expires_at' => $pickupFrom->copy()->addDay(),
            'status' => ListingStatus::AVAILABLE,
        ];
    }

    public function expired(): static
    {
        return $this->state(fn () => ['status' => ListingStatus::EXPIRED]);
    }
}

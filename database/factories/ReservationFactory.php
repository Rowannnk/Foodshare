<?php

namespace Database\Factories;

use App\Enums\ReservationStatus;
use App\Models\FoodListing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'food_listing_id' => FoodListing::factory(),
            'user_id' => User::factory(),
            'quantity' => fake()->numberBetween(1, 5),
            'status' => ReservationStatus::PENDING,
            'reserved_at' => now(),
        ];
    }

    public function cancelled(): static
    {
        return $this->state(fn () => ['status' => ReservationStatus::CANCELLED]);
    }
}

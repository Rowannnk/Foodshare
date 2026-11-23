<?php

namespace Database\Factories;

use App\Enums\PickupStatus;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PickupFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(),
            'confirmed_by' => null,
            'pickup_code' => strtoupper(fake()->unique()->bothify('????-####')),
            'status' => PickupStatus::PENDING,
            'collected_at' => null,
        ];
    }

    public function collected(): static
    {
        return $this->state(fn () => [
            'status' => PickupStatus::COLLECTED,
            'collected_at' => now(),
        ]);
    }
}

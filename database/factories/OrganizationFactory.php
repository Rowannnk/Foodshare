<?php

namespace Database\Factories;

use App\Enums\OrganizationType;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'type' => fake()->randomElement([
                OrganizationType::RESTAURANT,
                OrganizationType::CAFE,
                OrganizationType::BAKERY,
                OrganizationType::SUPERMARKET,
            ]),
            'contact_email' => fake()->companyEmail(),
            'contact_phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'is_active' => true,
        ];
    }

    public function charity(): static
    {
        return $this->state(fn () => ['type' => OrganizationType::CHARITY]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use App\Models\FoodListing;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Organization;
use App\Models\Reservation;
use App\Models\Pickup;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void

    {

        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        $donors = User::factory(5)->donor()->create();
        $recipients = User::factory(5)->create();

        $names = [
            'Bakery',
            'Fruit & Vegetables',
            'Dairy',
            'Prepared Meals',
            'Drinks',
        ];

        foreach ($names as $name) {
            FoodCategory::factory()->create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        $categories = FoodCategory::all();

        foreach ($donors as $donor) {
            $organizations = Organization::factory(2)->for($donor)->create();

        foreach ($organizations as $organization) {
                FoodListing::factory(3)
                    ->for($organization)
                    ->state(fn () => [
                        'food_category_id' => $categories->random()->id,
                    ])
                    ->create();
            }
        }
        $listings = FoodListing::all();

        foreach ($recipients as $recipient) {
            foreach ($listings->random(3) as $listing) {
                Reservation::factory()
                    ->for($listing)
                    ->for($recipient)
                    ->create([
                        'quantity' => fake()->numberBetween(1, min(5, $listing->quantity)),
                    ]);
                }
            }
        $reservations = Reservation::with('foodListing.organization')->get();

        foreach ($reservations as $index => $reservation) {
            $pickup = Pickup::factory()->for($reservation);
                if ($index < 5) {
                    $pickup = $pickup->collected()->state([
                    'confirmed_by' => $reservation->foodListing->organization->user_id,
                    ]);
                }
                $pickup->create();
            }
        }
        
    
}

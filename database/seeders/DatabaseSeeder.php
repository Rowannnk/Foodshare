<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use App\Models\FoodListing;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Organization;


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
    }
}

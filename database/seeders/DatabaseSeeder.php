<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        User::factory(5)->donor()->create();
        User::factory(5)->create();

        $categories = [
            'Bakery',
            'Fruit & Vegetables',
            'Dairy',
            'Prepared Meals',
            'Drinks',
        ];

        foreach ($categories as $name) {
            FoodCategory::factory()->create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
}
    }
}

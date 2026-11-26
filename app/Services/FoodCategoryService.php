<?php

namespace App\Services;

use App\Models\FoodCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FoodCategoryService
{
    private const CACHE_KEY = 'food_categories.active';

    public function getActiveCategories(): Collection
    {
        return Cache::remember(
            self::CACHE_KEY,
            now()->addMinutes(30),
            fn () => FoodCategory::where('is_active', true)
                ->orderBy('name')
                ->get()
        );
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}

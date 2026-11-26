
<?php

use App\Models\FoodCategory;
use App\Services\FoodCategoryService;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::forget('food_categories.active');
});

it('caches active food categories and clears the cache when requested', function () {
    $firstCategory = FoodCategory::factory()->create([
        'name' => 'Bakery',
        'slug' => 'bakery',
        'is_active' => true,
    ]);

    $service = app(FoodCategoryService::class);

    $categories = $service->getActiveCategories();

    expect($categories->pluck('id'))->toContain($firstCategory->id);

    $secondCategory = FoodCategory::factory()->create([
        'name' => 'Drinks',
        'slug' => 'drinks',
        'is_active' => true,
    ]);
    $cachedCategories = $service->getActiveCategories();

    expect($cachedCategories->pluck('id'))->not->toContain($secondCategory->id);
    $service->clearCache();
    $freshCategories = $service->getActiveCategories();

    expect($freshCategories->pluck('id'))->toContain($secondCategory->id);
});

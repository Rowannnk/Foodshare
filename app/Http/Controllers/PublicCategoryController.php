<?php

namespace App\Http\Controllers;

use App\Enums\ListingStatus;
use App\Models\FoodCategory;
use Illuminate\View\View;

class PublicCategoryController extends Controller
{
    public function index(): View
    {
        $categories = FoodCategory::where('is_active', true)
            ->withCount([
                'foodListings as available_count' => function ($query) {
                    $query->where('status', ListingStatus::AVAILABLE);
                },
            ])
            ->orderBy('name')
            ->get();

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function show(FoodCategory $category): View
    {
        abort_unless($category->is_active, 404);

        $listings = $category->foodListings()
            ->with(['organization', 'foodCategory'])
            ->where('status', ListingStatus::AVAILABLE)
            ->latest()
            ->paginate(9);

        return view('categories.show', [
            'category' => $category,
            'listings' => $listings,
        ]);
    }
}
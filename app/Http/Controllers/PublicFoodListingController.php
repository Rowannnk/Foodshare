<?php

namespace App\Http\Controllers;

use App\Enums\ListingStatus;
use App\Models\FoodCategory;
use App\Models\FoodListing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicFoodListingController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'integer', 'exists:food_categories,id'],
        ]);

        $listings = FoodListing::with(['organization', 'foodCategory'])
            ->where('status', ListingStatus::AVAILABLE)
            ->when($validated['q'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($validated['category'] ?? null, function ($query, $category) {
                $query->where('food_category_id', $category);
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('food-listings.index', [
            'listings' => $listings,
            'categories' => FoodCategory::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function show(FoodListing $foodListing): View
    {
        $foodListing->load(['organization', 'foodCategory']);

        return view('food-listings.show', [
            'listing' => $foodListing,
        ]);
    }
}
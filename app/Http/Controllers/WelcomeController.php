<?php

namespace App\Http\Controllers;

use App\Enums\ListingStatus;
use App\Enums\PickupStatus;
use App\Models\FoodListing;
use App\Models\Organization;
use App\Models\Pickup;
use Illuminate\View\View;


class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke() : View
    {
        $latestListings = FoodListing::with(['organization', 'foodCategory'])
            ->where('status',ListingStatus::AVAILABLE)
            ->latest()
            ->take(3)
            ->get();

        return view('welcome', [
            'latestListings' => $latestListings,
            'availableCount' => FoodListing::where('status', ListingStatus::AVAILABLE)->count(),
            'organizationCount' => Organization::where('is_active', true)->count(),
            'collectedCount' => Pickup::where('status', PickupStatus::COLLECTED)->count(),
        ]);

    }
}

<?php

namespace App\Http\Controllers\Userzone;

use App\Enums\ListingStatus;
use App\Enums\PickupStatus;
use App\Enums\ReservationStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\FoodCategory;
use App\Models\FoodListing;
use App\Models\Organization;
use App\Models\Pickup;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $data = [];

        if ($user->isAdmin()) {
            $data = [
                'userCount' => User::count(),
                'organizationCount' => Organization::count(),
                'categoryCount' => FoodCategory::count(),
                'listingCount' => FoodListing::count(),
                'reservationCount' => Reservation::count(),
                'pendingPickupCount' => Pickup::where('status', PickupStatus::PENDING)->count(),
                'donorCount' => User::where('role', UserRole::DONOR)->count(),
                'recipientCount' => User::where('role', UserRole::RECIPIENT)->count(),
                'recentReservations' => Reservation::with(['user', 'foodListing'])
                    ->latest()
                    ->take(5)
                    ->get(),
            ];
        }

        if ($user->isDonor()) {
            $ownListings = fn () => FoodListing::whereHas(
                'organization',
                fn ($q) => $q->where('user_id', $user->id)
            );

            $ownPickups = fn () => Pickup::whereHas(
                'reservation.foodListing.organization',
                fn ($q) => $q->where('user_id', $user->id)
            );

            $data = [
                'activeListings' => $ownListings()->where('status', ListingStatus::AVAILABLE)->count(),
                'pendingPickupCount' => $ownPickups()->where('status', PickupStatus::PENDING)->count(),
                'collectedCount' => $ownPickups()->where('status', PickupStatus::COLLECTED)->count(),
                'pendingPickups' => $ownPickups()
                    ->where('status', PickupStatus::PENDING)
                    ->with(['reservation.user', 'reservation.foodListing'])
                    ->latest()
                    ->take(4)
                    ->get(),
                'recentListings' => $ownListings()->with('foodCategory')->latest()->take(4)->get(),
            ];
        }

        if ($user->isRecipient()) {
            $data = [
                'pendingCount' => $user->reservations()->where('status', ReservationStatus::PENDING)->count(),
                'collectedCount' => $user->reservations()->where('status', ReservationStatus::COLLECTED)->count(),
                'upcoming' => $user->reservations()
                    ->where('status', ReservationStatus::PENDING)
                    ->with(['foodListing.organization', 'pickup'])
                    ->latest()
                    ->take(3)
                    ->get(),
                'latestListings' => FoodListing::with(['organization', 'foodCategory'])
                    ->where('status', ListingStatus::AVAILABLE)
                    ->latest()
                    ->take(3)
                    ->get(),
            ];
        }

        return view('userzone.dashboard', $data);
    }
}
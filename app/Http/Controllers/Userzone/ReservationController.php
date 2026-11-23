<?php

namespace App\Http\Controllers\Userzone;

use App\Enums\ListingStatus;
use App\Enums\PickupStatus;
use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\FoodListing;
use App\Models\Pickup;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->isRecipient(), 403);

        $reservations = $request->user()
            ->reservations()
            ->with(['foodListing.organization', 'pickup'])
            ->latest()
            ->paginate(10);

        return view('userzone.reservations.index', [
            'reservations' => $reservations,
        ]);
    }

    public function store(StoreReservationRequest $request, FoodListing $foodListing): RedirectResponse
    {
        if (! $foodListing->isReservable()) {
            return back()->withErrors(['quantity' => 'This food cannot be reserved any more.']);
        }

        DB::transaction(function () use ($request, $foodListing) {
            $reservation = Reservation::create([
                'food_listing_id' => $foodListing->id,
                'user_id' => $request->user()->id,
                'quantity' => $request->validated('quantity'),
                'status' => ReservationStatus::PENDING,
                'reserved_at' => now(),
            ]);

            Pickup::create([
                'reservation_id' => $reservation->id,
                'pickup_code' => Pickup::generateCode(),
                'status' => PickupStatus::PENDING,
            ]);

            if ($foodListing->remainingQuantity() === 0) {
                $foodListing->update(['status' => ListingStatus::RESERVED]);
            }
        });

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Food reserved! Show your pickup code when you collect it.');
    }

    public function destroy(Request $request, Reservation $reservation): RedirectResponse
    {
        abort_unless($reservation->user_id === $request->user()->id, 403);

        if ($reservation->status !== ReservationStatus::PENDING) {
            return back()->withErrors(['reservation' => 'Only pending reservations can be cancelled.']);
        }

        DB::transaction(function () use ($reservation) {
            $reservation->update(['status' => ReservationStatus::CANCELLED]);
            $reservation->pickup?->delete();

            $listing = $reservation->foodListing;

            if ($listing->status === ListingStatus::RESERVED) {
                $listing->update(['status' => ListingStatus::AVAILABLE]);
            }
        });

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation cancelled.');
    }
}
<?php

namespace App\Http\Controllers\Userzone;

use App\Enums\ListingStatus;
use App\Enums\PickupStatus;
use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmPickupRequest;
use App\Models\Pickup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PickupController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Pickup::class);

        $user = $request->user();

        $pickups = Pickup::with([
            'reservation.user',
            'reservation.foodListing.organization',
            'confirmedBy',
        ])
            ->when($user->isDonor(), fn ($query) => $query->whereHas(
                'reservation.foodListing.organization',
                fn ($q) => $q->where('user_id', $user->id)
            ))
            ->when($user->isRecipient(), fn ($query) => $query->whereHas(
                'reservation',
                fn ($q) => $q->where('user_id', $user->id)
            ))
            ->latest()
            ->paginate(10);

        return view('userzone.pickups.index', [
            'pickups' => $pickups,
        ]);
    }

    public function confirm(ConfirmPickupRequest $request, Pickup $pickup): RedirectResponse
    {
        Gate::authorize('confirm', $pickup);

        if ($pickup->status !== PickupStatus::PENDING) {
            return back()->withErrors(['pickup' => 'This pickup was already handled.']);
        }

        DB::transaction(function () use ($request, $pickup) {
            $pickup->update([
                'status' => PickupStatus::COLLECTED,
                'collected_at' => now(),
                'confirmed_by' => $request->user()->id,
            ]);

            $pickup->reservation->update(['status' => ReservationStatus::COLLECTED]);

            $listing = $pickup->reservation->foodListing;

            $allCollected = $listing->reservations()
                ->where('status', '!=', ReservationStatus::CANCELLED)
                ->where('status', '!=', ReservationStatus::COLLECTED)
                ->doesntExist();

            if ($allCollected && $listing->remainingQuantity() === 0) {
                $listing->update(['status' => ListingStatus::COLLECTED]);
            }
        });

        return redirect()
            ->route('pickups.index')
            ->with('success', 'Pickup confirmed. Thank you for sharing food!');
    }
}
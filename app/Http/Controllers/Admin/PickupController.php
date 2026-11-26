<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pickup;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PickupController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Pickup::class);

        $pickups = Pickup::with([
            'reservation.user',
            'reservation.foodListing.organization',
            'confirmedBy',
        ])
            ->latest()
            ->paginate(10);

        return view('admin.pickups.index', [
            'pickups' => $pickups,
        ]);
    }
}

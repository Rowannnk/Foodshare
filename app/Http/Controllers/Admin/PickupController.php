<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PickupStatus;
use App\Http\Controllers\Controller;
use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PickupController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Pickup::class);

        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');

        $validStatuses = array_map(
            fn (PickupStatus $pickupStatus) => $pickupStatus->value,
            PickupStatus::cases()
        );

        $query = Pickup::with([
            'reservation.user',
            'reservation.foodListing.organization.user',
            'confirmedBy',
        ]);
        if ($search !== '') {
            $query->where(function ($searchQuery) use ($search) {
                $searchQuery->where('pickup_code', 'like', "%{$search}%")
                    ->orWhereHas('reservation.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('reservation.foodListing', function ($listingQuery) use ($search) {
                        $listingQuery->where('title', 'like', "%{$search}%")
                            ->orWhereHas('organization', function ($organizationQuery) use ($search) {
                                $organizationQuery->where('name', 'like', "%{$search}%")
                                    ->orWhereHas('user', function ($userQuery) use ($search) {
                                        $userQuery->where('name', 'like', "%{$search}%");
                                    });
                            });
                    });
            });
        }
        if (in_array($status, $validStatuses, true)) {
            $query->where('status', $status);
        } else {
            $status = '';
        }

        $pickups = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pickups.index', [
            'pickups' => $pickups,
            'search' => $search,
            'status' => $status,
        ]);
    }
}

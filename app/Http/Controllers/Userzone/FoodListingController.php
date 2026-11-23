<?php

namespace App\Http\Controllers\Userzone;

use App\Enums\ListingStatus;
use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodListingRequest;
use App\Models\FoodCategory;
use App\Models\FoodListing;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class FoodListingController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', FoodListing::class);

        $user = $request->user();

        $listings = FoodListing::with(['organization', 'foodCategory'])
            ->withCount('reservations')
            ->when(! $user->isAdmin(), function ($query) use ($user) {
                $query->whereHas('organization', fn ($q) => $q->where('user_id', $user->id));
            })
            ->latest()
            ->paginate(10);

        return view('userzone.food-listings.index', [
            'listings' => $listings,
        ]);
    }

    public function create(Request $request): View
    {
        Gate::authorize('create', FoodListing::class);

        return view('userzone.food-listings.create', $this->formData($request->user()));
    }

    public function store(FoodListingRequest $request): RedirectResponse
    {
        Gate::authorize('create', FoodListing::class);

        $foodListing = FoodListing::create(
            $request->validated() + ['status' => ListingStatus::AVAILABLE]
        );

        return redirect()
            ->route('my-listings.show', $foodListing)
            ->with('success', 'Food listing created.');
    }

    public function show(FoodListing $foodListing): View
    {
        Gate::authorize('view', $foodListing);

        $foodListing->load(['organization', 'foodCategory', 'reservations.user']);

        return view('userzone.food-listings.show', [
            'listing' => $foodListing,
        ]);
    }

    public function edit(Request $request, FoodListing $foodListing): View
    {
        Gate::authorize('update', $foodListing);

        return view('userzone.food-listings.edit', $this->formData($request->user()) + [
            'listing' => $foodListing,
        ]);
    }

    public function update(FoodListingRequest $request, FoodListing $foodListing): RedirectResponse
    {
        Gate::authorize('update', $foodListing);

        $foodListing->update($request->validated());

        return redirect()
            ->route('my-listings.show', $foodListing)
            ->with('success', 'Food listing updated.');
    }

    public function destroy(FoodListing $foodListing): RedirectResponse
    {
        Gate::authorize('delete', $foodListing);

        $hasActiveReservations = $foodListing->reservations()
            ->where('status', '!=', ReservationStatus::CANCELLED)
            ->exists();

        if ($hasActiveReservations) {
            return back()->withErrors([
                'listing' => 'This listing has active reservations, so it cannot be deleted.',
            ]);
        }

        $foodListing->delete();

        return redirect()
            ->route('my-listings.index')
            ->with('success', 'Food listing deleted.');
    }

    private function formData(User $user): array
    {
        $organizations = Organization::where('is_active', true)
            ->when(! $user->isAdmin(), fn ($query) => $query->where('user_id', $user->id))
            ->orderBy('name')
            ->get();

        return [
            'organizations' => $organizations,
            'categories' => FoodCategory::where('is_active', true)->orderBy('name')->get(),
        ];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ListingStatus;
use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodListingRequest;
use App\Models\FoodListing;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Services\FoodCategoryService;

class FoodListingController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', FoodListing::class);

        $listings = FoodListing::with(['organization', 'foodCategory'])
            ->withCount('reservations')
            ->latest()
            ->paginate(10);

        return view('admin.food-listings.index', [
            'listings' => $listings,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', FoodListing::class);

        return view('admin.food-listings.create', $this->formData());
    }

    public function store(FoodListingRequest $request): RedirectResponse
    {
        Gate::authorize('create', FoodListing::class);

        $data = Arr::except($request->validated(), 'photo');

        $data['photo_path'] = $request->file('photo')
            ->store('food-listings', 'public');

        $listing = FoodListing::create($data + [
            'status' => ListingStatus::AVAILABLE,
        ]);

        return redirect()
            ->route('admin.food-listings.show', $listing)
            ->with('success', 'Food listing created.');
    }

    public function show(FoodListing $foodListing): View
    {
        Gate::authorize('view', $foodListing);

        $foodListing->load([
            'organization',
            'foodCategory',
            'reservations.user',
        ]);

        return view('admin.food-listings.show', [
            'listing' => $foodListing,
        ]);
    }

    public function edit(FoodListing $foodListing): View
    {
        Gate::authorize('update', $foodListing);

        return view('admin.food-listings.edit', $this->formData() + [
            'listing' => $foodListing,
        ]);
    }

    public function update(
        FoodListingRequest $request,
        FoodListing $foodListing
    ): RedirectResponse {
        Gate::authorize('update', $foodListing);

        $data = Arr::except($request->validated(), 'photo');

        if ($request->hasFile('photo')) {
            if ($foodListing->photo_path) {
                Storage::disk('public')->delete($foodListing->photo_path);
            }

            $data['photo_path'] = $request->file('photo')
                ->store('food-listings', 'public');
        }

        $foodListing->update($data);

        return redirect()
            ->route('admin.food-listings.show', $foodListing)
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

        if ($foodListing->photo_path) {
            Storage::disk('public')->delete($foodListing->photo_path);
        }

        $foodListing->delete();

        return redirect()
            ->route('admin.food-listings.index')
            ->with('success', 'Food listing deleted.');
    }

    private function formData(): array
    {
        return [
            'organizations' => Organization::where('is_active', true)
                ->orderBy('name')
                ->get(),

            'categories' => app(FoodCategoryService::class)->getActiveCategories(),
        ];
    }
}

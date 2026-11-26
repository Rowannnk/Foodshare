<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ListingStatus;
use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodListingRequest;
use App\Models\FoodCategory;
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
    
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', FoodListing::class);

        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');
        $categoryId = $request->input('food_category_id', '');
        $organizationId = $request->input('organization_id', '');

        $statuses = collect(ListingStatus::cases())
            ->mapWithKeys(fn (ListingStatus $listingStatus) => [
                $listingStatus->value => ucfirst($listingStatus->value),
            ])
            ->all();

        $categories = FoodCategory::orderBy('name')
            ->pluck('name', 'id')
            ->all();

        $organizations = Organization::orderBy('name')
            ->pluck('name', 'id')
            ->all();

        $query = FoodListing::with(['organization', 'foodCategory'])
            ->withCount('reservations');

        if ($search !== '') {
            $query->where(function ($searchQuery) use ($search) {
                $searchQuery->where('title', 'like', "%{$search}%")
                    ->orWhereHas('organization', function ($organizationQuery) use ($search) {
                        $organizationQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }
        if (array_key_exists($status, $statuses)) {
            $query->where('status', $status);
        } else {
            $status = '';
        }
        if (array_key_exists((int) $categoryId, $categories)) {
            $query->where('food_category_id', $categoryId);
        } else {
            $categoryId = '';
        }

        if (array_key_exists((int) $organizationId, $organizations)) {
            $query->where('organization_id', $organizationId);
        } else {
            $organizationId = '';
        }

        $listings = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.food-listings.index', [
            'listings' => $listings,
            'search' => $search,
            'statuses' => $statuses,
            'categories' => $categories,
            'organizations' => $organizations,
            'selectedStatus' => $status,
            'selectedCategory' => $categoryId,
            'selectedOrganization' => $organizationId,
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

<?php

namespace App\Http\Controllers\Userzone;

use App\Enums\ListingStatus;
use App\Enums\OrganizationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Organization::class);

        $user = $request->user();

        $organizations = Organization::with('user')
            ->withCount('foodListings')
            ->when(! $user->isAdmin(), fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->paginate(10);

        return view('userzone.organizations.index', [
            'organizations' => $organizations,
        ]);
    }

    public function create(Request $request): View
    {
        Gate::authorize('create', Organization::class);

        return view('userzone.organizations.create', [
            'types' => OrganizationType::forRole($request->user()->role),
        ]);
    }

    public function store(OrganizationRequest $request): RedirectResponse
    {
        Gate::authorize('create', Organization::class);

        $validated = $request->validated();

        $organization = Organization::create($validated + [
            'user_id' => $request->user()->id,
            'slug' => Organization::generateSlug($validated['name']),
        ]);

        return redirect()
            ->route('organizations.show', $organization)
            ->with('success', 'Organization created.');
    }

    public function show(Request $request, Organization $organization): View
    {
        Gate::authorize('view', $organization);

        $canManage = $request->user()->can('update', $organization);

        $listings = $organization->foodListings()
            ->with('foodCategory')
            ->when(! $canManage, fn ($query) => $query->where('status', ListingStatus::AVAILABLE))
            ->latest()
            ->get();

        return view('userzone.organizations.show', [
            'organization' => $organization->load('user'),
            'listings' => $listings,
            'canManage' => $canManage,
        ]);
    }

    public function edit(Request $request, Organization $organization): View
    {
        Gate::authorize('update', $organization);

        return view('userzone.organizations.edit', [
            'organization' => $organization,
            'types' => OrganizationType::forRole($request->user()->role),
        ]);
    }

    public function update(OrganizationRequest $request, Organization $organization): RedirectResponse
    {
        Gate::authorize('update', $organization);

        $organization->update($request->validated());

        return redirect()
            ->route('organizations.show', $organization)
            ->with('success', 'Organization updated.');
    }

    public function destroy(Organization $organization): RedirectResponse
    {
        Gate::authorize('delete', $organization);

        if ($organization->foodListings()->exists()) {
            return back()->withErrors([
                'organization' => 'This organization has food listings, so it cannot be deleted. You can deactivate it instead.',
            ]);
        }

        $organization->delete();

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Organization deleted.');
    }
}
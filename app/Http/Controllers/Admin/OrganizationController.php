<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrganizationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminOrganizationRequest;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
   
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Organization::class);

        $search = trim($request->input('search', ''));
        $type = $request->input('type', '');

        $validTypes = array_map(
            fn (OrganizationType $organizationType) => $organizationType->value,
            OrganizationType::cases()
        );

        $query = Organization::with('user')
            ->withCount('foodListings');
        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }
        if (in_array($type, $validTypes, true)) {
            $query->where('type', $type);
        } else {
            $type = '';
        }

        $organizations = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.organizations.index', [
            'organizations' => $organizations,
            'types' => OrganizationType::cases(),
            'search' => $search,
            'selectedType' => $type,
        ]);
    }


    public function create(): View
    {
        Gate::authorize('create', Organization::class);

        return view('admin.organizations.create', [
            'organization' => null,
            'types' => OrganizationType::cases(),
            'owners' => User::whereIn('role', ['donor', 'recipient'])
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(AdminOrganizationRequest $request): RedirectResponse
    {
        Gate::authorize('create', Organization::class);

        $validated = $request->validated();

        $organization = Organization::create($validated + [
            'slug' => Organization::generateSlug($validated['name']),
        ]);

        return redirect()
            ->route('admin.organizations.show', $organization)
            ->with('success', 'Organization created.');
    }

    public function show(Organization $organization): View
    {
        Gate::authorize('view', $organization);

        $listings = $organization->foodListings()
            ->with('foodCategory')
            ->latest()
            ->paginate(10);

        return view('admin.organizations.show', [
            'organization' => $organization->load('user'),
            'listings' => $listings,
        ]);
    }

    public function edit(Organization $organization): View
    {
        Gate::authorize('update', $organization);

        return view('admin.organizations.edit', [
            'organization' => $organization,
            'types' => OrganizationType::cases(),
            'owners' => User::whereIn('role', ['donor', 'recipient'])
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(
        AdminOrganizationRequest $request,
        Organization $organization
    ): RedirectResponse {
        Gate::authorize('update', $organization);

        $validated = $request->validated();

        if ($organization->name !== $validated['name']) {
            $validated['slug'] = Organization::generateSlug($validated['name']);
        }

        $organization->update($validated);

        return redirect()
            ->route('admin.organizations.show', $organization)
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
            ->route('admin.organizations.index')
            ->with('success', 'Organization deleted.');
    }
}

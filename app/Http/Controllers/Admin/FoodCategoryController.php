<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodCategoryRequest;
use App\Models\FoodCategory;
use App\Services\FoodCategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class FoodCategoryController extends Controller
{
   public function index(Request $request): View
    {
        Gate::authorize('viewAny', FoodCategory::class);

        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');

        $query = FoodCategory::withCount('foodListings');

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        } else {
            $status = '';
        }

        $categories = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', [
            'categories' => $categories,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', FoodCategory::class);

        return view('admin.categories.create');
    }

    public function store(FoodCategoryRequest $request): RedirectResponse
    {
        Gate::authorize('create', FoodCategory::class);

        $validated = $request->validated();

        $category = FoodCategory::create($validated + [
            'slug' => FoodCategory::generateSlug($validated['name']),
        ]);

        app(FoodCategoryService::class)->clearCache();

        return redirect()
            ->route('admin.categories.show', $category)
            ->with('success', 'Category created.');
    }

    public function show(FoodCategory $category): View
    {
        Gate::authorize('view', $category);

        $listings = $category->foodListings()
            ->with('organization')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.categories.show', [
            'category' => $category->loadCount('foodListings'),
            'listings' => $listings,
        ]);
    }

    public function edit(FoodCategory $category): View
    {
        Gate::authorize('update', $category);

        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(FoodCategoryRequest $request, FoodCategory $category): RedirectResponse
    {
        Gate::authorize('update', $category);

        $validated = $request->validated();

        $category->update($validated + [
            'slug' => FoodCategory::generateSlug($validated['name'], $category->id),
        ]);
        app(FoodCategoryService::class)->clearCache();

        return redirect()
            ->route('admin.categories.show', $category)
            ->with('success', 'Category updated.');
    }

    public function destroy(FoodCategory $category): RedirectResponse
    {
        Gate::authorize('delete', $category);

        if ($category->foodListings()->exists()) {
            return back()->withErrors([
                'category' => 'This category has food listings, so it cannot be deleted. You can deactivate it instead.',
            ]);
        }

        $category->delete();
        app(FoodCategoryService::class)->clearCache();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted.');
    }
}
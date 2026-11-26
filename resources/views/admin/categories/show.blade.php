<x-layouts.admin :title="$category->name . ' - Admin - FoodLoop'">

    <div class="mx-auto max-w-7xl space-y-8 px-6 py-10 lg:px-8">

        {{-- Breadcrumb --}}
        <a href="{{ route('admin.categories.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-[#88766D] transition hover:text-[#B96F4D]">
            <x-heroicon-o-arrow-left class="h-4 w-4" />
            Back to categories
        </a>

        {{-- Category heading --}}
        <section class="overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white shadow-sm">

            <div class="flex flex-col justify-between gap-6 p-6 sm:flex-row sm:items-center sm:p-8">

                <div class="flex items-start gap-5">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#B96F4D]">
                        <x-heroicon-o-tag class="h-8 w-8" />
                    </div>

                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            @if ($category->is_active)
                                <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                                    Active
                                </span>
                            @else
                                <span class="rounded-full bg-stone-100 px-3 py-1 text-xs font-bold text-stone-600">
                                    Inactive
                                </span>
                            @endif

                            <span class="text-xs font-semibold text-[#A18F84]">
                                Category #{{ $category->id }}
                            </span>
                        </div>

                        <h1 class="brand-font mt-3 text-3xl font-extrabold tracking-tight text-[#4A342B] sm:text-4xl">
                            {{ $category->name }}
                        </h1>

                        <p class="mt-2 text-sm text-[#88766D]">
                            Food category details and associated listings.
                        </p>
                    </div>
                </div>

                <a href="{{ route('admin.categories.edit', $category) }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#4A342B] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#765748]">
                    <x-heroicon-o-pencil-square class="h-4 w-4" />
                    Edit Category
                </a>

            </div>

        </section>

        {{-- Information cards --}}
        <section class="grid gap-4 md:grid-cols-2">

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F7E8DE] text-[#B96F4D]">
                        <x-heroicon-o-rectangle-stack class="h-5 w-5" />
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">Food Listings</p>
                        <p class="mt-1 text-2xl font-extrabold text-[#4A342B] tabular-nums">
                            {{ $category->food_listings_count }}
                        </p>
                    </div>
                </div>
                <p class="mt-4 text-xs text-[#A18F84]">
                    Total listings assigned to this category.
                </p>
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#FFF8F2] text-[#8E583D]">
                        <x-heroicon-o-link class="h-5 w-5" />
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">Category Slug</p>
                        <p class="mt-2 break-all font-mono text-sm font-bold text-[#4A342B]">
                            {{ $category->slug }}
                        </p>
                    </div>
                </div>
                <p class="mt-4 text-xs text-[#A18F84]">
                    Unique identifier used in the system.
                </p>
            </div>

        </section>

        {{-- Description --}}
        <section class="rounded-2xl border border-[#EAD8CD] bg-white p-6 shadow-sm sm:p-8">
            <h2 class="font-bold text-[#4A342B]">Category Description</h2>

            @if ($category->description)
                <p class="mt-3 max-w-3xl text-sm leading-7 text-[#6B5A51]">
                    {{ $category->description }}
                </p>
            @else
                <p class="mt-3 text-sm italic text-[#A18F84]">
                    No description has been added for this category.
                </p>
            @endif
        </section>

        {{-- Associated listings --}}
        <section class="overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white shadow-sm">

            <div class="flex flex-col justify-between gap-2 border-b border-[#EAD8CD] px-6 py-5 sm:flex-row sm:items-center">
                <div>
                    <h2 class="font-bold text-[#4A342B]">Food Listings</h2>
                    <p class="mt-1 text-xs text-[#A18F84]">
                        Recent food listings in this category.
                    </p>
                </div>

                <span class="w-fit rounded-lg bg-[#FFF8F2] px-3 py-2 text-xs font-bold text-[#806F66]">
                    Showing {{ $listings->count() }} recent listings
                </span>
            </div>

            <div class="divide-y divide-[#F1E6DE]">

                @forelse ($listings as $listing)
                    <a href="{{ route('admin.food-listings.show', $listing) }}"
                       class="flex flex-col justify-between gap-4 p-5 transition hover:bg-[#FFFCF9] sm:flex-row sm:items-center sm:px-6">

                        <div class="flex min-w-0 items-center gap-4">
                            <div class="shrink-0">
                                <x-listing-thumb :listing="$listing" />
                            </div>

                            <div class="min-w-0">
                                <p class="truncate font-bold text-[#4A342B]">
                                    {{ $listing->title }}
                                </p>
                                <p class="mt-1 text-sm text-[#88766D]">
                                    {{ $listing->organization->name }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4 sm:justify-end">
                            <span class="rounded-full bg-[#F7E8DE] px-3 py-1.5 text-xs font-bold capitalize text-[#8E583D]">
                                {{ $listing->status->value }}
                            </span>

                            <x-heroicon-o-chevron-right class="h-5 w-5 text-[#A18F84]" />
                        </div>

                    </a>
                @empty
                    <div class="px-6 py-14 text-center">
                        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#B96F4D]">
                            <x-heroicon-o-rectangle-stack class="h-7 w-7" />
                        </span>

                        <h3 class="mt-4 font-bold text-[#4A342B]">
                            No food listings yet
                        </h3>

                        <p class="mt-1 text-sm text-[#88766D]">
                            There are currently no listings assigned to this category.
                        </p>
                    </div>
                @endforelse

            </div>

        </section>

    </div>

</x-layouts.admin>

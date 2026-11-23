<x-layouts.public :title="$category->name . ' - Admin - FoodLoop'">

    <section class="mx-auto max-w-4xl px-6 py-12 lg:px-8">

        <a href="{{ route('admin.categories.index') }}" class="text-sm font-semibold text-[#B96F4D] hover:underline">
            &larr; Back to categories
        </a>

        <div class="mt-5 flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
            <div>
                @if ($category->is_active)
                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">Active</span>
                @else
                    <span class="rounded-full bg-stone-100 px-3 py-1 text-xs font-bold text-stone-500">Inactive</span>
                @endif

                <h1 class="brand-font mt-4 text-4xl font-extrabold tracking-tight text-[#4A342B]">
                    {{ $category->name }}
                </h1>
                <p class="mt-2 text-[#88766D]">Slug: {{ $category->slug }}</p>
            </div>

            <a href="{{ route('admin.categories.edit', $category) }}"
               class="w-fit rounded-full bg-[#E9A17D] px-6 py-3 text-sm font-bold text-[#4A342B] hover:bg-[#D98E69]">
                Edit
            </a>
        </div>

        @if ($category->description)
            <p class="mt-6 max-w-2xl leading-7 text-[#6B5A51]">{{ $category->description }}</p>
        @endif

        <p class="mt-8 text-sm text-[#88766D]">
            {{ $category->food_listings_count }} {{ Str::plural('listing', $category->food_listings_count) }} in this category
        </p>

        <div class="mt-4 space-y-3">
            @forelse ($listings as $listing)
                <a href="{{ route('food-listings.show', $listing) }}"
                   class="flex items-center justify-between rounded-2xl border border-[#EAD8CD] bg-white p-5 transition hover:shadow-lg">
                    <div>
                        <p class="font-bold text-[#4A342B]">{{ $listing->title }}</p>
                        <p class="text-sm text-[#88766D]">{{ $listing->organization->name }}</p>
                    </div>
                    <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-bold capitalize text-[#8E583D]">
                        {{ $listing->status->value }}
                    </span>
                </a>
            @empty
                <p class="rounded-2xl border border-[#EAD8CD] bg-white px-6 py-10 text-center text-[#88766D]">
                    No food listings in this category yet.
                </p>
            @endforelse
        </div>
    </section>

</x-layouts.public>
<x-layouts.public :title="$category->name . ' - FoodLoop'">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">
            <a href="{{ route('categories.index') }}"
               class="text-sm font-semibold text-[#B96F4D] hover:underline">
                &larr; All categories
            </a>

            <h1 class="brand-font mt-5 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                {{ $category->name }}
            </h1>

            @if ($category->description)
                <p class="mt-3 max-w-xl text-[#88766D]">
                    {{ $category->description }}
                </p>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <p class="text-sm text-[#88766D]">
            {{ $listings->total() }} {{ Str::plural('listing', $listings->total()) }} available
        </p>

        <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($listings as $listing)
                <x-listing-card :listing="$listing" />
            @empty
                <div class="col-span-full rounded-3xl border border-[#EAD8CD] bg-white px-6 py-16 text-center">
                    <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">
                        Nothing here right now
                    </h2>
                    <p class="mt-2 text-sm text-[#88766D]">
                        There is no available food in this category. Please check back soon.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $listings->links() }}
        </div>
    </section>

</x-layouts.public>
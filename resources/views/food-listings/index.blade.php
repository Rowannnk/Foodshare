<x-layouts.public title="Available food - FoodLoop">
    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                From our community
            </p>
            <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                Available food
            </h1>
            <p class="mt-3 max-w-xl text-[#88766D]">
                Browse the surplus food that local organizations are sharing right now.
            </p>
            <form method="GET" action="{{ route('food-listings.index') }}"
                  class="mt-8 grid gap-3 sm:grid-cols-[1fr_220px_auto]">
                <div>
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Search food, for example bread"
                           class="w-full rounded-full border border-[#EAD8CD] bg-[#FFF8F2] px-5 py-3 text-sm focus:border-[#E9A17D] focus:outline-none focus:ring-2 focus:ring-[#E9A17D]/40">
                    @error('q')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <select name="category"
                            class="w-full rounded-full border border-[#EAD8CD] bg-[#FFF8F2] px-5 py-3 text-sm focus:border-[#E9A17D] focus:outline-none focus:ring-2 focus:ring-[#E9A17D]/40">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                        Search
                    </button>

                    @if (request()->hasAny(['q', 'category']))
                        <a href="{{ route('food-listings.index') }}"
                           class="rounded-full border border-[#EAD8CD] px-5 py-3 text-sm font-semibold text-[#806F66] transition hover:bg-[#FFF3EB]">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        <p class="text-sm text-[#88766D]">
            {{ $listings->total() }} {{ Str::plural('listing', $listings->total()) }} found
        </p>

        <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($listings as $listing)
                <x-listing-card :listing="$listing" />
            @empty
                <div class="col-span-full rounded-3xl border border-[#EAD8CD] bg-white px-6 py-16 text-center">
                    <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">
                        No food found
                    </h2>
                    <p class="mt-2 text-sm text-[#88766D]">
                        Try another word or choose a different category.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $listings->links() }}
        </div>
    </section>

</x-layouts.public>
<div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <h2 class="brand-font text-2xl font-extrabold text-[#4A342B]">Your reservations</h2>
        <p class="mt-1 text-sm text-[#88766D]">Show your pickup code when you collect the food.</p>
    </div>

    @if (auth()->user()->hasActiveOrganization())
        <a href="{{ route('food-listings.index') }}"
           class="w-fit rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] shadow-lg shadow-[#E9A17D]/30 transition hover:-translate-y-0.5 hover:bg-[#D98E69]">
            Find food
        </a>
    @else
        <a href="{{ route('organizations.create') }}"
           class="w-fit rounded-full bg-[#4A342B] px-7 py-3 text-sm font-bold text-white transition hover:bg-[#765748]">
            Create your organization first
        </a>
    @endif
</div>

<div class="mt-8 grid gap-4 sm:grid-cols-2">
    @foreach ([
        ['Active reservations', $pendingCount, 'heroicon-o-clock'],
        ['Collected', $collectedCount, 'heroicon-o-check-circle'],
    ] as [$label, $count, $icon])
        <div class="flex items-center gap-4 rounded-2xl border border-[#EAD8CD] bg-white p-6">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#8E583D]">
                <x-dynamic-component :component="$icon" class="h-6 w-6" />
            </span>
            <div>
                <p class="brand-font text-3xl font-extrabold leading-none text-[#4A342B]">{{ $count }}</p>
                <p class="mt-1 text-sm text-[#88766D]">{{ $label }}</p>
            </div>
        </div>
    @endforeach
</div>

<section class="mt-12">
    <div class="flex items-center justify-between">
        <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">Your next pickups</h3>
        <a href="{{ route('reservations.index') }}" class="text-sm font-semibold text-[#B96F4D] hover:underline">See all</a>
    </div>

    <div class="mt-4 grid gap-4 md:grid-cols-3">
        @forelse ($upcoming as $reservation)
            <article class="rounded-2xl border border-[#EAD8CD] bg-white p-6">
                <p class="font-bold text-[#4A342B]">{{ $reservation->foodListing->title }}</p>
                <p class="mt-1 text-sm text-[#88766D]">
                    {{ $reservation->quantity }} items from {{ $reservation->foodListing->organization->name }}
                </p>
                <p class="mt-1 text-sm text-[#88766D]">
                    {{ $reservation->foodListing->pickup_from->format('d M, H:i') }}
                    - {{ $reservation->foodListing->pickup_until->format('H:i') }}
                </p>

                @if ($reservation->pickup)
                    <div class="mt-4 rounded-xl bg-[#FFF8F2] px-4 py-3 text-center">
                        <p class="text-xs text-[#A18F84]">Pickup code</p>
                        <p class="brand-font text-lg font-extrabold tracking-wider text-[#4A342B]">
                            {{ $reservation->pickup->pickup_code }}
                        </p>
                    </div>
                @endif
            </article>
        @empty
            <p class="col-span-full rounded-2xl border border-[#EAD8CD] bg-white px-6 py-10 text-center text-sm text-[#88766D]">
                You have no active reservations. Find some food and reserve what you need.
            </p>
        @endforelse
    </div>
</section>

<section class="mt-12">
    <div class="flex items-center justify-between">
        <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">Fresh food to reserve</h3>
        <a href="{{ route('food-listings.index') }}" class="text-sm font-semibold text-[#B96F4D] hover:underline">See all</a>
    </div>

    <div class="mt-4 grid gap-6 md:grid-cols-3">
        @forelse ($latestListings as $listing)
            <x-listing-card :listing="$listing" />
        @empty
            <p class="col-span-full text-sm text-[#88766D]">No food is available right now.</p>
        @endforelse
    </div>
</section>
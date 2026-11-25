<div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <h2 class="brand-font text-2xl font-extrabold text-[#4A342B]">Your food sharing</h2>
        <p class="mt-1 text-sm text-[#88766D]">See what is waiting for you today.</p>
    </div>

    @if (auth()->user()->hasActiveOrganization())
        <a href="{{ route('my-listings.create') }}"
           class="w-fit rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] shadow-lg shadow-[#E9A17D]/30 transition hover:-translate-y-0.5 hover:bg-[#D98E69]">
            + New listing
        </a>
    @else
        <a href="{{ route('organizations.create') }}"
           class="w-fit rounded-full bg-[#4A342B] px-7 py-3 text-sm font-bold text-white transition hover:bg-[#765748]">
            Create your organization first
        </a>
    @endif
</div>

<div class="mt-8 grid gap-4 sm:grid-cols-3">
    @foreach ([
        ['Active listings', $activeListings, 'heroicon-o-shopping-bag'],
        ['Pickups waiting', $pendingPickupCount, 'heroicon-o-clock'],
        ['Collected pickups', $collectedCount, 'heroicon-o-check-circle'],
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

<div class="mt-12 grid gap-8 lg:grid-cols-2">

    <section>
        <div class="flex items-center justify-between">
            <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">Pickups to confirm</h3>
            <a href="{{ route('pickups.index') }}" class="text-sm font-semibold text-[#B96F4D] hover:underline">See all</a>
        </div>

        <div class="mt-4 space-y-3">
            @forelse ($pendingPickups as $pickup)
                <a href="{{ route('pickups.index') }}"
                   class="flex items-center justify-between rounded-2xl border border-[#EAD8CD] bg-white p-5 transition hover:shadow-lg">
                    <div>
                        <p class="font-bold text-[#4A342B]">{{ $pickup->reservation->foodListing->title }}</p>
                        <p class="text-sm text-[#88766D]">
                            {{ $pickup->reservation->quantity }} items for {{ $pickup->reservation->user->name }}
                        </p>
                    </div>
                    <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-bold text-[#8E583D]">Confirm</span>
                </a>
            @empty
                <p class="rounded-2xl border border-[#EAD8CD] bg-white px-6 py-10 text-center text-sm text-[#88766D]">
                    No pickups are waiting right now.
                </p>
            @endforelse
        </div>
    </section>

    <section>
        <div class="flex items-center justify-between">
            <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">Your latest listings</h3>
            <a href="{{ route('my-listings.index') }}" class="text-sm font-semibold text-[#B96F4D] hover:underline">See all</a>
        </div>

        <div class="mt-4 space-y-3">
            @forelse ($recentListings as $listing)
                <a href="{{ route('my-listings.show', $listing) }}"
                   class="flex items-center justify-between rounded-2xl border border-[#EAD8CD] bg-white p-5 transition hover:shadow-lg">
                    <div>
                        <p class="font-bold text-[#4A342B]">{{ $listing->title }}</p>
                        <p class="text-sm text-[#88766D]">
                            {{ $listing->foodCategory->name }} &middot; {{ $listing->quantity }} items
                        </p>
                    </div>
                    <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-bold capitalize text-[#8E583D]">
                        {{ $listing->status->value }}
                    </span>
                </a>
            @empty
                <p class="rounded-2xl border border-[#EAD8CD] bg-white px-6 py-10 text-center text-sm text-[#88766D]">
                    You have no listings yet.
                </p>
            @endforelse
        </div>
    </section>

</div>
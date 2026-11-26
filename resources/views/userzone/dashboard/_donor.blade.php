<div class="space-y-10">
    <div class="flex flex-col justify-between gap-5 rounded-3xl border border-[#EAD8CD] bg-white p-6 sm:flex-row sm:items-center sm:p-8">
        <div>
            <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-[#B96F4D]">
                Donor workspace
            </p>
            <h2 class="brand-font mt-2 text-2xl font-extrabold tracking-tight text-[#4A342B] sm:text-3xl">
                Your food sharing
            </h2>
            <p class="mt-2 max-w-lg text-sm leading-6 text-[#88766D]">
                Manage your food listings and keep track of the pickups happening in your organization.
            </p>
        </div>

        @if (auth()->user()->hasActiveOrganization())
            <a href="{{ route('my-listings.create') }}"
               class="inline-flex w-fit shrink-0 items-center justify-center rounded-full bg-[#E9A17D] px-7 py-3.5 text-sm font-bold text-[#4A342B] shadow-md shadow-[#E9A17D]/20 transition hover:-translate-y-0.5 hover:bg-[#D98E69]">
                + Create new listing
            </a>
        @else
            <a href="{{ route('organizations.create') }}"
               class="inline-flex w-fit shrink-0 items-center justify-center rounded-full bg-[#4A342B] px-7 py-3.5 text-sm font-bold text-white transition hover:bg-[#765748]">
                Create your organization
            </a>
        @endif
    </div>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ([
            [
                'label' => 'Active listings',
                'count' => $activeListings,
                'description' => 'Food currently available',
                'icon' => 'heroicon-o-shopping-bag',
            ],
            [
                'label' => 'Pickups waiting',
                'count' => $pendingPickupCount,
                'description' => 'Awaiting your confirmation',
                'icon' => 'heroicon-o-clock',
            ],
            [
                'label' => 'Collected pickups',
                'count' => $collectedCount,
                'description' => 'Successfully collected',
                'icon' => 'heroicon-o-check-circle',
            ],
        ] as $stat)
            <div class="relative overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white p-6 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#4A342B]/5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">
                            {{ $stat['label'] }}
                        </p>
                        <p class="brand-font mt-3 text-4xl font-extrabold leading-none tracking-tight text-[#4A342B]">
                            {{ $stat['count'] }}
                        </p>
                        <p class="mt-3 text-xs text-[#A18F84]">
                            {{ $stat['description'] }}
                        </p>
                    </div>
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#8E583D]">
                        <x-dynamic-component :component="$stat['icon']" class="h-6 w-6" />
                    </span>
                </div>

            </div>
        @endforeach

    </div>
    <div class="grid gap-8 xl:grid-cols-2">
        <section class="min-w-0">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">
                            Pickups to confirm
                        </h3>
                        @if ($pendingPickupCount > 0)
                            <span class="inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-[#FFF0DC] px-2 text-xs font-extrabold text-[#A66328]">
                                {{ $pendingPickupCount }}
                            </span>
                        @endif
                    </div>

                    <p class="mt-1 text-sm text-[#88766D]">
                        Reservations waiting for collection confirmation.
                    </p>
                </div>

                <a href="{{ route('pickups.index') }}"
                   class="shrink-0 text-sm font-bold text-[#B96F4D] transition hover:text-[#8E583D] hover:underline">
                    View all &rarr;
                </a>
            </div>

            <div class="mt-5 space-y-3">

                @forelse ($pendingPickups as $pickup)

                    <a href="{{ route('pickups.index') }}"
                       class="group flex items-center gap-4 rounded-2xl border border-[#EAD8CD] bg-white p-4 transition hover:-translate-y-0.5 hover:border-[#E9A17D] hover:shadow-lg hover:shadow-[#4A342B]/5 sm:p-5">

                        <div class="shrink-0">
                            <x-listing-thumb :listing="$pickup->reservation->foodListing" size="h-16 w-16" />
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="truncate font-bold text-[#4A342B] transition group-hover:text-[#B96F4D]">
                                {{ $pickup->reservation->foodListing->title }}
                            </p>

                            <p class="mt-1 text-sm text-[#88766D]">
                                {{ $pickup->reservation->quantity }} items
                            </p>

                            <p class="mt-1 text-xs text-[#A18F84]">
                                Reserved by {{ $pickup->reservation->user->name }}
                            </p>
                        </div>

                        <div class="shrink-0 text-right">
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-[#F2D5AC] bg-[#FFF0DC] px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-[#A66328]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#A66328]"></span>
                                Pending
                            </span>

                           
                        </div>

                    </a>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#EAD8CD] bg-white px-6 py-12 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#8E583D]">
                            <x-heroicon-o-check-circle class="h-7 w-7" />
                        </div>

                        <h4 class="brand-font mt-4 font-extrabold text-[#4A342B]">
                            All caught up!
                        </h4>

                        <p class="mt-2 text-sm leading-6 text-[#88766D]">
                            There are no pickups waiting for your confirmation right now.
                        </p>

                        <a href="{{ route('pickups.index') }}"
                           class="mt-4 inline-flex text-sm font-bold text-[#B96F4D] hover:underline">
                            View pickup history &rarr;
                        </a>
                    </div>

                @endforelse

            </div>
        </section>
        <section class="min-w-0">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">
                        Your latest listings
                    </h3>
                    <p class="mt-1 text-sm text-[#88766D]">
                        Keep track of the food you are sharing.
                    </p>
                </div>
                <a href="{{ route('my-listings.index') }}"
                   class="shrink-0 text-sm font-bold text-[#B96F4D] transition hover:text-[#8E583D] hover:underline">
                    View all &rarr;
                </a>
            </div>
            <div class="mt-5 space-y-3">
                @forelse ($recentListings as $listing)
                    <a href="{{ route('my-listings.show', $listing) }}"
                       class="group flex items-center gap-4 rounded-2xl border border-[#EAD8CD] bg-white p-4 transition hover:-translate-y-0.5 hover:border-[#E9A17D] hover:shadow-lg hover:shadow-[#4A342B]/5 sm:p-5">

                        <div class="shrink-0">
                            <x-listing-thumb :listing="$listing" size="h-16 w-16" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-bold text-[#4A342B] transition group-hover:text-[#B96F4D]">
                                {{ $listing->title }}
                            </p>
                            <p class="mt-1 text-sm text-[#88766D]">
                                {{ $listing->foodCategory->name }}
                            </p>
                            <p class="mt-1 text-xs text-[#A18F84]">
                                Quantity: {{ $listing->quantity }}
                            </p>
                        </div>
                        <div class="shrink-0 text-right">
                            <span class="inline-flex rounded-full border border-[#EAD8CD] bg-[#FFF8F2] px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-[#8E583D]">
                                {{ $listing->status->value }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#EAD8CD] bg-white px-6 py-12 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#8E583D]">
                            <x-heroicon-o-shopping-bag class="h-7 w-7" />
                        </div>
                        <h4 class="brand-font mt-4 font-extrabold text-[#4A342B]">
                            No food listings yet
                        </h4>
                        <p class="mt-2 text-sm leading-6 text-[#88766D]">
                            Start sharing surplus food with people in your community.
                        </p>
                        @if (auth()->user()->hasActiveOrganization())
                            <a href="{{ route('my-listings.create') }}"
                               class="mt-4 inline-flex text-sm font-bold text-[#B96F4D] hover:underline">
                                Create your first listing &rarr;
                            </a>
                        @else
                            <a href="{{ route('organizations.create') }}"
                               class="mt-4 inline-flex text-sm font-bold text-[#B96F4D] hover:underline">
                                Create your organization &rarr;
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>

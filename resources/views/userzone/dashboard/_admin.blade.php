<div class="mx-auto max-w-7xl space-y-6 px-6 py-8 lg:px-8">
    <section>
        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
            Welcome back, {{ auth()->user()->name }}
        </p>

        <h1 class="brand-font mt-2 text-3xl font-extrabold tracking-tight text-[#4A342B]">
            Platform overview
        </h1>

        <p class="mt-1 text-sm text-[#88766D]">
            The numbers and latest activity on FoodLoop.
        </p>
    </section>
    <section class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">

        @foreach ([
            ['Users', $userCount, 'heroicon-o-users'],
            ['Organizations', $organizationCount, 'heroicon-o-building-office-2'],
            ['Food categories', $categoryCount, 'heroicon-o-tag'],
            ['Food listings', $listingCount, 'heroicon-o-shopping-bag'],
            ['Reservations', $reservationCount, 'heroicon-o-clipboard-document-check'],
            ['Pickups waiting', $pendingPickupCount, 'heroicon-o-clock'],
        ] as [$label, $count, $icon])

            <div class="flex items-center gap-3 rounded-xl border border-[#EAD8CD] bg-white p-3 shadow-sm">

                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F7E8DE] text-[#8E583D]">
                    <x-dynamic-component :component="$icon" class="h-5 w-5" />
                </span>

                <div class="min-w-0">
                    <p class="text-xs font-semibold text-[#88766D]">
                        {{ $label }}
                    </p>

                    <p class="mt-0.5 text-2xl font-extrabold leading-tight text-[#4A342B] tabular-nums">
                        {{ $count }}
                    </p>
                </div>

            </div>

        @endforeach

    </section>
    <div class="grid gap-6 xl:grid-cols-[1.8fr_1fr]">
        <section class="min-w-0 overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-[#EAD8CD] px-5 py-4">
                <div>
                    <h2 class="font-bold text-[#4A342B]">
                        Latest reservations
                    </h2>

                    <p class="mt-1 text-xs text-[#A18F84]">
                        Recently created food reservations.
                    </p>
                </div>

                <span class="rounded-lg bg-[#FFF8F2] px-3 py-2 text-xs font-bold text-[#806F66]">
                    {{ $recentReservations->count() }} recent
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">

                    <thead class="bg-[#FFF8F2] text-[10px] font-extrabold uppercase tracking-wider text-[#A18F84]">
                        <tr>
                            <th class="px-5 py-3">Food</th>
                            <th class="px-5 py-3">Recipient</th>
                            <th class="px-5 py-3">Qty</th>
                            <th class="px-5 py-3">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#F1E6DE]">

                        @forelse ($recentReservations as $reservation)

                            <tr class="transition hover:bg-[#FFFCF9]">

                                <td class="px-5 py-3 font-semibold text-[#4A342B]">
                                    <div class="flex items-center gap-3">
                                        <x-listing-thumb
                                            :listing="$reservation->foodListing"
                                            size="h-10 w-10 shrink-0"
                                        />

                                        <span class="min-w-0">
                                            {{ $reservation->foodListing->title }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-5 py-3 text-[#88766D]">
                                    {{ $reservation->user->name }}
                                </td>

                                <td class="px-5 py-3 font-semibold text-[#4A342B]">
                                    {{ $reservation->quantity }}
                                </td>

                                <td class="px-5 py-3">
                                    <span class="inline-flex rounded-full bg-[#F7E8DE] px-3 py-1 text-[10px] font-bold capitalize text-[#8E583D]">
                                        {{ $reservation->status->value }}
                                    </span>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center">
                                    <x-heroicon-o-clipboard-document-list class="mx-auto h-9 w-9 text-[#C6B3A7]" />

                                    <p class="mt-3 text-sm font-semibold text-[#4A342B]">
                                        No reservations yet
                                    </p>

                                    <p class="mt-1 text-xs text-[#88766D]">
                                        New reservations will appear here.
                                    </p>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </section>
        <section class="min-w-0 overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white shadow-sm">

            <div class="border-b border-[#EAD8CD] px-5 py-4">
                <h2 class="font-bold text-[#4A342B]">
                    Community
                </h2>

                <p class="mt-1 text-xs text-[#A18F84]">
                    FoodLoop community breakdown.
                </p>
            </div>
            <div class="space-y-0 p-4">
                <div class="flex items-center gap-3 py-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F7E8DE] text-[#B96F4D]">
                        <x-heroicon-o-building-storefront class="h-5 w-5" />
                    </span>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-[#4A342B]">
                            Food businesses
                        </p>
                        <p class="text-xs text-[#A18F84]">
                            Donors
                        </p>
                    </div>

                    <span class="text-xl font-extrabold text-[#4A342B] tabular-nums">
                        {{ $donorCount }}
                    </span>
                </div>

                <div class="border-t border-[#F1E6DE]"></div>
                <div class="flex items-center gap-3 py-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F7E8DE] text-[#B96F4D]">
                        <x-heroicon-o-heart class="h-5 w-5" />
                    </span>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-[#4A342B]">
                            Charities
                        </p>
                        <p class="text-xs text-[#A18F84]">
                            Recipients
                        </p>
                    </div>

                    <span class="text-xl font-extrabold text-[#4A342B] tabular-nums">
                        {{ $recipientCount }}
                    </span>
                </div>

                <div class="border-t border-[#F1E6DE]"></div>
                <div class="flex items-center gap-3 py-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F7E8DE] text-[#B96F4D]">
                        <x-heroicon-o-users class="h-5 w-5" />
                    </span>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-[#4A342B]">
                            All users
                        </p>
                        <p class="text-xs text-[#A18F84]">
                            Registered platform users
                        </p>
                    </div>

                    <span class="text-xl font-extrabold text-[#4A342B] tabular-nums">
                        {{ $userCount }}
                    </span>
                </div>

            </div>

        </section>

    </div>

</div>

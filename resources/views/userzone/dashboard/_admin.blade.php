<div>
    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
        Welcome back, {{ auth()->user()->name }}
    </p>
    <h1 class="brand-font mt-2 text-3xl font-extrabold tracking-tight text-[#4A342B]">
        Platform overview
    </h1>
    <p class="mt-1 text-sm text-[#88766D]">The numbers and the latest activity on FoodLoop.</p>
</div>


<div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ([
        ['Users', $userCount, 'heroicon-o-users'],
        ['Organizations', $organizationCount, 'heroicon-o-building-office-2'],
        ['Food categories', $categoryCount, 'heroicon-o-tag'],
        ['Food listings', $listingCount, 'heroicon-o-shopping-bag'],
        ['Reservations', $reservationCount, 'heroicon-o-clipboard-document-check'],
        ['Pickups waiting', $pendingPickupCount, 'heroicon-o-clock'],
    ] as [$label, $count, $icon])
        <div class="flex items-center gap-4 rounded-2xl border border-[#EAD8CD] bg-white p-5">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#8E583D]">
                <x-dynamic-component :component="$icon" class="h-6 w-6" />
            </span>
            <div class="min-w-0">
                <p class="brand-font text-3xl font-extrabold leading-none text-[#4A342B]">{{ $count }}</p>
                <p class="mt-1 truncate text-sm text-[#88766D]">{{ $label }}</p>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-10 grid gap-8 xl:grid-cols-[1.8fr_1fr]">

    <section class="min-w-0">
        <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">Latest reservations</h2>

        <div class="mt-4 overflow-x-auto rounded-2xl border border-[#EAD8CD] bg-white">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#EAD8CD] bg-[#FFF8F2] text-xs uppercase tracking-widest text-[#A18F84]">
                    <tr>
                        <th class="px-5 py-3">Food</th>
                        <th class="px-5 py-3">Recipient</th>
                        <th class="px-5 py-3">Qty</th>
                        <th class="px-5 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAD8CD]">
                    @forelse ($recentReservations as $reservation)
                        <tr>
                            <td class="px-5 py-3 font-semibold text-[#4A342B]">
                                <div class="flex items-center gap-3">
                                    <x-listing-thumb :listing="$reservation->foodListing" size="h-10 w-10" />
                                    {{ $reservation->foodListing->title }}
                                </div>
                            </td>
                            <td class="px-5 py-3 text-[#88766D]">{{ $reservation->user->name }}</td>
                            <td class="px-5 py-3">{{ $reservation->quantity }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-bold capitalize text-[#8E583D]">
                                    {{ $reservation->status->value }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-[#88766D]">No reservations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="min-w-0">
        <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">Community</h2>

        <div class="mt-4 space-y-3 rounded-2xl border border-[#EAD8CD] bg-white p-6">
            <div class="flex items-center justify-between">
                <span class="text-sm text-[#88766D]">Food businesses (donors)</span>
                <span class="brand-font text-xl font-extrabold text-[#4A342B]">{{ $donorCount }}</span>
            </div>
            <div class="flex items-center justify-between border-t border-[#EAD8CD] pt-3">
                <span class="text-sm text-[#88766D]">Charities (recipients)</span>
                <span class="brand-font text-xl font-extrabold text-[#4A342B]">{{ $recipientCount }}</span>
            </div>
            <div class="flex items-center justify-between border-t border-[#EAD8CD] pt-3">
                <span class="text-sm text-[#88766D]">All users</span>
                <span class="brand-font text-xl font-extrabold text-[#4A342B]">{{ $userCount }}</span>
            </div>
        </div>
    </section>

</div>
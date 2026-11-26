<x-layouts.admin title="Pickups - Admin - FoodLoop">
    <div class="mx-auto max-w-7xl space-y-6 px-6 py-8 lg:px-8">
        <section>
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                Operations Management
            </p>

            <h1 class="brand-font mt-2 text-3xl font-extrabold tracking-tight text-[#4A342B]">
                Pickups
            </h1>

            <p class="mt-1 text-sm text-[#88766D]">
                Monitor food pickups and track their collection progress.
            </p>
        </section>
        <section class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <div class="flex items-center gap-3 rounded-xl border border-[#EAD8CD] bg-white p-3 shadow-sm">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F7E8DE] text-[#B96F4D]">
                    <x-heroicon-o-calendar-days class="h-5 w-5" />
                </span>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-[#88766D]">
                        Total Pickups
                    </p>
                    <p class="mt-0.5 text-2xl font-extrabold leading-tight text-[#4A342B] tabular-nums">
                        {{ $pickups->total() }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-xl border border-[#EAD8CD] bg-white p-3 shadow-sm">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-orange-50 text-orange-700">
                    <x-heroicon-o-clock class="h-5 w-5" />
                </span>

                <div class="min-w-0">
                    <p class="text-xs font-semibold text-[#88766D]">
                        Pending Pickups
                    </p>
                    <p class="mt-0.5 text-2xl font-extrabold leading-tight text-[#4A342B] tabular-nums">
                        {{ $pickups->where('status', \App\Enums\PickupStatus::PENDING)->count() }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-xl border border-[#EAD8CD] bg-white p-3 shadow-sm">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-700">
                    <x-heroicon-o-check-circle class="h-5 w-5" />
                </span>

                <div class="min-w-0">
                    <p class="text-xs font-semibold text-[#88766D]">
                        Collected Pickups
                    </p>
                    <p class="mt-0.5 text-2xl font-extrabold leading-tight text-[#4A342B] tabular-nums">
                        {{ $pickups->where('status', \App\Enums\PickupStatus::COLLECTED)->count() }}
                    </p>
                </div>
            </div>

        </section>
        <x-admin.search-filter
            :action="route('admin.pickups.index')"
            placeholder="Search by pickup code, listing, recipient or donor..."
            :filters="[]"
        />
        <section class="overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white shadow-sm">
            <div class="flex flex-col justify-between gap-2 border-b border-[#EAD8CD] px-5 py-4 sm:flex-row sm:items-center">
                <div>
                    <h2 class="font-bold text-[#4A342B]">
                        All Pickup Records
                    </h2>

                    <p class="mt-1 text-xs text-[#A18F84]">
                        Review pickup details, recipients, donors, and collection status.
                    </p>
                </div>

                <span class="w-fit rounded-lg bg-[#FFF8F2] px-3 py-2 text-xs font-bold text-[#806F66]">
                    {{ $pickups->firstItem() ?? 0 }}–{{ $pickups->lastItem() ?? 0 }}
                    of {{ $pickups->total() }} pickups
                </span>
            </div>

            <div class="space-y-4 p-4 sm:p-5">

                @forelse ($pickups as $pickup)

                    @php
                        $reservation = $pickup->reservation;
                        $listing = $reservation->foodListing;
                        $organization = $listing->organization;

                        $statusStyles = match ($pickup->status->value) {
                            'pending' => 'bg-[#FFF0DC] text-[#A66328] border-[#F2D5AC]',
                            'collected' => 'bg-[#E8F3E8] text-[#47764B] border-[#C9DFC9]',
                            default => 'bg-[#F7E8DE] text-[#8E583D] border-[#EAD8CD]',
                        };
                    @endphp

                    <article class="overflow-hidden rounded-xl border border-[#EAD8CD] bg-white transition hover:border-[#D9B69F] hover:shadow-sm">

                        <div class="flex flex-col gap-5 p-4 sm:flex-row sm:items-center">
                            <div class="flex min-w-0 flex-1 items-start gap-3">

                                <x-listing-thumb
                                    :listing="$listing"
                                    size="h-20 w-20 shrink-0"
                                />

                                <div class="min-w-0 flex-1">

                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider {{ $statusStyles }}">
                                            {{ str_replace('_', ' ', $pickup->status->value) }}
                                        </span>

                                        <span class="text-xs text-[#A18F84]">
                                            Pickup #{{ $pickup->id }}
                                        </span>
                                    </div>

                                    <h3 class="brand-font mt-2 text-lg font-extrabold text-[#4A342B]">
                                        {{ $listing->title }}
                                    </h3>

                                    <p class="mt-1 text-sm text-[#88766D]">
                                        {{ $reservation->quantity }} items from
                                        {{ $organization->name }}
                                    </p>

                                    <div class="mt-3 flex flex-wrap gap-x-5 gap-y-1 text-xs">

                                        <p class="text-[#88766D]">
                                            Recipient:
                                            <span class="font-semibold text-[#4A342B]">
                                                {{ $reservation->user->name }}
                                            </span>
                                        </p>

                                        <p class="text-[#88766D]">
                                            Donor:
                                            <span class="font-semibold text-[#4A342B]">
                                                {{ $organization->user->name }}
                                            </span>
                                        </p>

                                    </div>

                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-2 border-t border-[#EAD8CD] pt-4 sm:grid-cols-2 lg:w-[390px] lg:shrink-0 lg:border-l lg:border-t-0 lg:pl-4 lg:pt-0">

                                <div class="rounded-lg bg-[#FFF8F2] px-3 py-3">
                                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-[#A18F84]">
                                        Pickup Code
                                    </p>

                                    <p class="brand-font mt-1.5 text-lg font-extrabold tracking-wider text-[#4A342B]">
                                        {{ $pickup->pickup_code }}
                                    </p>
                                </div>

                                <div class="rounded-lg bg-[#FFF8F2] px-3 py-3">
                                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-[#A18F84]">
                                        Scheduled Pickup
                                    </p>

                                    <p class="mt-1.5 text-xs font-bold text-[#4A342B]">
                                        {{ $listing->pickup_from->format('d M Y, H:i') }}
                                    </p>

                                    <p class="mt-1 text-xs text-[#88766D]">
                                        Until {{ $listing->pickup_until->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                @if ($pickup->status === \App\Enums\PickupStatus::COLLECTED)

                                    <div class="col-span-full rounded-lg bg-[#E8F3E8] px-3 py-2.5">
                                        <p class="text-xs font-bold text-[#47764B]">
                                            Successfully Collected
                                        </p>

                                        <p class="mt-1 text-xs text-[#638267]">
                                            {{ $pickup->collected_at?->format('d M Y, H:i') ?? 'Collection time unavailable' }}
                                        </p>

                                        @if ($pickup->confirmedBy)
                                            <p class="mt-1 text-xs text-[#638267]">
                                                Confirmed by {{ $pickup->confirmedBy->name }}
                                            </p>
                                        @endif
                                    </div>
                                @else
                                    <div class="col-span-full rounded-lg border border-[#F2D5AC] bg-[#FFF0DC] px-3 py-2.5">
                                        <p class="text-xs font-bold text-[#A66328]">
                                            Waiting for Collection
                                        </p>

                                        <p class="mt-1 text-xs text-[#A66328]">
                                            The donor has not confirmed this pickup yet.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-[#EAD8CD] bg-[#FFFCF9] px-6 py-12 text-center">

                        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#F7E8DE] text-[#B96F4D]">
                            <x-heroicon-o-calendar-days class="h-6 w-6" />
                        </span>

                        <h3 class="mt-3 font-bold text-[#4A342B]">
                            No pickups found
                        </h3>
                        <p class="mt-1 text-sm text-[#88766D]">
                            Pickup records will appear here when recipients reserve food.
                        </p>
                    </div>
                @endforelse
            </div>
            @if ($pickups->hasPages())
                <div class="border-t border-[#EAD8CD] px-5 py-4">
                    {{ $pickups->links() }}
                </div>
            @endif

        </section>

    </div>

</x-layouts.admin>

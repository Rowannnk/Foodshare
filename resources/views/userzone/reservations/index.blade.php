<x-layouts.public title="My reservations - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                Hello, {{ auth()->user()->name }}
            </p>

            <div class="mt-3 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <h1 class="brand-font text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                        My reservations
                    </h1>

                    <p class="mt-3 max-w-xl text-sm leading-6 text-[#88766D]">
                        Manage your food reservations and check your pickup details.
                    </p>
                </div>

                <a href="{{ route('food-listings.index') }}"
                   class="inline-flex w-fit items-center justify-center rounded-full bg-[#E9A17D] px-6 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                    Browse available food
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        @error('reservation')
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                {{ $message }}
            </div>
        @enderror

        <div class="mb-6 flex items-center justify-between">
            <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">
                Your reservations
            </h2>

            <p class="text-sm text-[#88766D]">
                {{ $reservations->total() }} reservations
            </p>
        </div>

        <div class="space-y-5">
            @forelse ($reservations as $reservation)

                <article class="overflow-hidden rounded-3xl border border-[#EAD8CD] bg-white transition hover:shadow-md">

                    <div class="flex flex-col gap-6 p-5 sm:p-6 lg:flex-row lg:items-center">
                        <div class="flex min-w-0 flex-1 items-start gap-4">
                            <x-listing-thumb
                                :listing="$reservation->foodListing"
                                size="h-24 w-24 shrink-0"
                            />

                            <div class="min-w-0 flex-1">

                                <div class="flex flex-wrap items-center gap-2">
                                    @php
                                        $statusStyles = match ($reservation->status->value) {
                                            'pending' => 'bg-[#FFF0DC] text-[#A66328] border-[#F2D5AC]',
                                            'collected' => 'bg-[#E8F3E8] text-[#47764B] border-[#C9DFC9]',
                                            'cancelled' => 'bg-[#FCEAEA] text-[#A94442] border-[#F0CACA]',
                                            default => 'bg-[#F7E8DE] text-[#8E583D] border-[#EAD8CD]',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-[10px] font-extrabold uppercase tracking-widest {{ $statusStyles }}">
                                        {{ $reservation->status->value }}
                                    </span>
                                </div>

                                <h3 class="brand-font mt-3 text-xl font-extrabold text-[#4A342B]">
                                    <a href="{{ route('food-listings.show', $reservation->foodListing) }}"
                                       class="transition hover:text-[#B96F4D]">
                                        {{ $reservation->foodListing->title }}
                                    </a>
                                </h3>

                                <p class="mt-1 text-sm text-[#88766D]">
                                    {{ $reservation->quantity }} items
                                    <span class="mx-1 text-[#D8C4B8]">•</span>
                                    {{ $reservation->foodListing->organization->name }}
                                </p>

                                <p class="mt-2 text-sm text-[#88766D]">
                                    Pickup:
                                    <span class="font-semibold text-[#4A342B]">
                                        {{ $reservation->foodListing->pickup_from->format('d M, H:i') }}
                                        – {{ $reservation->foodListing->pickup_until->format('H:i') }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-[#EAD8CD] pt-5 lg:w-64 lg:shrink-0 lg:border-l lg:border-t-0 lg:pl-6 lg:pt-0">

                            @if ($reservation->pickup)
                                <div class="rounded-2xl bg-[#FFF8F2] px-5 py-4 text-center">
                                    <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#A18F84]">
                                        Your pickup code
                                    </p>

                                    <p class="brand-font mt-2 text-2xl font-extrabold tracking-[0.2em] text-[#4A342B]">
                                        {{ $reservation->pickup->pickup_code }}
                                    </p>

                                    <p class="mt-1 text-xs text-[#88766D]">
                                        Show this code to the donor.
                                    </p>
                                </div>
                            @else
                                <div class="rounded-2xl bg-[#FFF8F2] px-5 py-4 text-center">
                                    <p class="text-sm font-semibold text-[#806F66]">
                                        Pickup code not available yet
                                    </p>
                                </div>
                            @endif

                            @if ($reservation->status === \App\Enums\ReservationStatus::PENDING)
                                <form method="POST"
                                      action="{{ route('reservations.destroy', $reservation) }}"
                                      onsubmit="return confirm('Cancel this reservation?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="w-full rounded-full border border-[#EAD8CD] px-5 py-2.5 text-sm font-semibold text-[#806F66] transition hover:border-[#D9B6A1] hover:bg-[#FFF3EB] hover:text-[#8E583D]">
                                        Cancel reservation
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                </article>

            @empty

                <div class="rounded-3xl border border-[#EAD8CD] bg-white px-6 py-16 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#8E583D]">
                        <x-heroicon-o-shopping-bag class="h-8 w-8" />
                    </div>

                    <h2 class="brand-font mt-5 text-2xl font-extrabold text-[#4A342B]">
                        No reservations yet
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#88766D]">
                        You haven't reserved any food yet. Explore available food shared by organizations and reserve what you need.
                    </p>

                    <a href="{{ route('food-listings.index') }}"
                       class="mt-6 inline-flex rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                        Browse available food
                    </a>
                </div>

            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($reservations->hasPages())
            <div class="mt-10">
                {{ $reservations->links() }}
            </div>
        @endif

    </section>

</x-layouts.public>

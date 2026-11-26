<x-layouts.public title="My reservations - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                Hello, {{ auth()->user()->name }}
            </p>

            <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                My reservations
            </h1>

            <p class="mt-3 max-w-xl text-[#88766D]">
                Show your pickup code to the donor when you collect your food.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        @error('reservation')
            <p class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                {{ $message }}
            </p>
        @enderror

        <div class="space-y-4">
            @forelse ($reservations as $reservation)
                <article class="flex flex-col gap-4 rounded-[1.5rem] border border-[#EAD8CD] bg-white p-6 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-4">
                    <x-listing-thumb :listing="$reservation->foodListing" size="h-20 w-20" />

                    <div>
                        <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-extrabold uppercase tracking-widest text-[#8E583D]">
                            {{ $reservation->status->value }}
                        </span>

                        <h2 class="brand-font mt-3 text-xl font-extrabold text-[#4A342B]">
                            <a href="{{ route('food-listings.show', $reservation->foodListing) }}" class="hover:underline">
                                {{ $reservation->foodListing->title }}
                            </a>
                        </h2>

                        <p class="mt-1 text-sm text-[#88766D]">
                            {{ $reservation->quantity }} items from {{ $reservation->foodListing->organization->name }}
                        </p>

                        <p class="mt-1 text-sm text-[#88766D]">
                            Pickup from {{ $reservation->foodListing->pickup_from->format('d M, H:i') }}
                            until {{ $reservation->foodListing->pickup_until->format('H:i') }}
                        </p>
                    </div>
                </div>

                    <div class="flex flex-col items-start gap-3 sm:items-end">
                        @if ($reservation->pickup)
                            <div class="rounded-2xl bg-[#FFF8F2] px-5 py-3 text-center">
                                <p class="text-xs text-[#A18F84]">Pickup code</p>
                                <p class="brand-font text-xl font-extrabold tracking-wider text-[#4A342B]">
                                    {{ $reservation->pickup->pickup_code }}
                                </p>
                            </div>
                        @endif

                        @if ($reservation->status === \App\Enums\ReservationStatus::PENDING)
                            <form method="POST" action="{{ route('reservations.destroy', $reservation) }}"
                                  onsubmit="return confirm('Cancel this reservation?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="rounded-full border border-[#EAD8CD] px-5 py-2 text-sm font-semibold text-[#806F66] transition hover:bg-[#FFF3EB]">
                                    Cancel reservation
                                </button>
                            </form>
                        @endif
                    </div>

                </article>
            @empty
                <div class="rounded-3xl border border-[#EAD8CD] bg-white px-6 py-16 text-center">
                    <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">No reservations yet</h2>
                    <p class="mt-2 text-sm text-[#88766D]">Find some food and reserve what you need.</p>
                    <a href="{{ route('food-listings.index') }}"
                       class="mt-6 inline-flex rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] hover:bg-[#D98E69]">
                        Browse available food
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $reservations->links() }}
        </div>
    </section>

</x-layouts.public>
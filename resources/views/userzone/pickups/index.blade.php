<x-layouts.public title="Pickups - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                {{ auth()->user()->name }}
            </p>

            <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                Pickups
            </h1>

            <p class="mt-3 max-w-xl text-[#88766D]">
                @if (auth()->user()->isRecipient())
                    Show your pickup code to the donor when you collect your food.
                @else
                    Ask the recipient for the pickup code, then type it to confirm that the food was collected.
                @endif
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        @error('pickup')
            <p class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                {{ $message }}
            </p>
        @enderror

        <div class="space-y-4">
            @forelse ($pickups as $pickup)
                @php
                    $reservation = $pickup->reservation;
                    $listing = $reservation->foodListing;
                @endphp

                <article class="flex flex-col gap-6 rounded-[1.5rem] border border-[#EAD8CD] bg-white p-6 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-extrabold uppercase tracking-widest text-[#8E583D]">
                            {{ $pickup->status->value }}
                        </span>

                        <h2 class="brand-font mt-3 text-xl font-extrabold text-[#4A342B]">
                            {{ $listing->title }}
                        </h2>

                        <p class="mt-1 text-sm text-[#88766D]">
                            {{ $reservation->quantity }} items from {{ $listing->organization->name }}
                        </p>

                        @unless (auth()->user()->isRecipient())
                            <p class="mt-1 text-sm text-[#88766D]">
                                Recipient: {{ $reservation->user->name }}
                            </p>
                        @endunless

                        <p class="mt-1 text-sm text-[#88766D]">
                            Pickup {{ $listing->pickup_from->format('d M, H:i') }} - {{ $listing->pickup_until->format('H:i') }}
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 lg:items-end">

                        @if (auth()->user()->isRecipient() || auth()->user()->isAdmin())
                            <div class="rounded-2xl bg-[#FFF8F2] px-5 py-3 text-center">
                                <p class="text-xs text-[#A18F84]">Pickup code</p>
                                <p class="brand-font text-xl font-extrabold tracking-wider text-[#4A342B]">
                                    {{ $pickup->pickup_code }}
                                </p>
                            </div>
                        @endif

                        @if ($pickup->status === \App\Enums\PickupStatus::PENDING)
                            @can('confirm', $pickup)
                                <form method="POST" action="{{ route('pickups.confirm', $pickup) }}" class="flex flex-col gap-2 lg:items-end">
                                    @csrf
                                    <input type="hidden" name="pickup_id" value="{{ $pickup->id }}">

                                    <div class="flex gap-2">
                                        <input type="text"
                                               name="pickup_code"
                                               placeholder="ABCD-1234"
                                               value="{{ old('pickup_id') == $pickup->id ? old('pickup_code') : '' }}"
                                               class="w-40 rounded-full border border-[#EAD8CD] bg-[#FFF8F2] px-4 py-2 text-sm focus:border-[#E9A17D] focus:outline-none focus:ring-2 focus:ring-[#E9A17D]/40">

                                        <button type="submit"
                                                class="rounded-full bg-[#E9A17D] px-5 py-2 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                                            Confirm pickup
                                        </button>
                                    </div>

                                    @if (old('pickup_id') == $pickup->id)
                                        @error('pickup_code')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    @endif
                                </form>
                            @endcan
                        @elseif ($pickup->status === \App\Enums\PickupStatus::COLLECTED)
                            <p class="text-sm text-[#88766D]">
                                Collected {{ $pickup->collected_at?->format('d M, H:i') }}
                                @if ($pickup->confirmedBy)
                                    &middot; confirmed by {{ $pickup->confirmedBy->name }}
                                @endif
                            </p>
                        @endif
                    </div>

                </article>
            @empty
                <div class="rounded-3xl border border-[#EAD8CD] bg-white px-6 py-16 text-center">
                    <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">No pickups yet</h2>
                    <p class="mt-2 text-sm text-[#88766D]">A pickup appears here when food is reserved.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $pickups->links() }}
        </div>
    </section>

</x-layouts.public>
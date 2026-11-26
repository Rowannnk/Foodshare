<x-layouts.public title="Pickups - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                Hello, {{ auth()->user()->name }}
            </p>

            <div class="mt-3">
                <h1 class="brand-font text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                    Pickups
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-6 text-[#88766D]">
                    @if (auth()->user()->isRecipient())
                        Show your pickup code to the donor when you collect your food.
                    @elseif (auth()->user()->isDonor())
                        Ask the recipient for their pickup code and enter it to confirm collection.
                    @else
                        Follow all food pickups and their collection status.
                    @endif
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        @error('pickup')
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                {{ $message }}
            </div>
        @enderror

        <div class="mb-6">
            <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">
                Pickup records
            </h2>
            <p class="mt-1 text-sm text-[#88766D]">
                View pickup details and collection progress.
            </p>
        </div>

        <div class="space-y-5">

            @forelse ($pickups as $pickup)

                @php
                    $reservation = $pickup->reservation;
                    $listing = $reservation->foodListing;

                    $statusStyles = match ($pickup->status->value) {
                        'pending' => 'bg-[#FFF0DC] text-[#A66328] border-[#F2D5AC]',
                        'collected' => 'bg-[#E8F3E8] text-[#47764B] border-[#C9DFC9]',
                        default => 'bg-[#F7E8DE] text-[#8E583D] border-[#EAD8CD]',
                    };
                @endphp

                <article class="overflow-hidden rounded-3xl border border-[#EAD8CD] bg-white transition hover:shadow-md">

                    <div class="flex flex-col gap-6 p-5 sm:p-6 lg:flex-row lg:items-center">
                        <div class="flex min-w-0 flex-1 items-start gap-4">

                            <x-listing-thumb
                                :listing="$listing"
                                size="h-24 w-24 shrink-0"
                            />

                            <div class="min-w-0 flex-1">

                                <span class="inline-flex items-center rounded-full border px-3 py-1 text-[10px] font-extrabold uppercase tracking-widest {{ $statusStyles }}">
                                    {{ $pickup->status->value }}
                                </span>

                                <h2 class="brand-font mt-3 text-xl font-extrabold text-[#4A342B]">
                                    {{ $listing->title }}
                                </h2>

                                <p class="mt-1 text-sm text-[#88766D]">
                                    {{ $reservation->quantity }} items from
                                    {{ $listing->organization->name }}
                                </p>

                                @unless (auth()->user()->isRecipient())
                                    <p class="mt-2 text-sm text-[#88766D]">
                                        Recipient:
                                        <span class="font-semibold text-[#4A342B]">
                                            {{ $reservation->user->name }}
                                        </span>
                                    </p>
                                @endunless

                                <div class="mt-3 rounded-xl bg-[#FFF8F2] px-4 py-3">
                                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-[#A18F84]">
                                        Pickup time
                                    </p>
                                    <p class="mt-1 text-sm font-bold text-[#4A342B]">
                                        {{ $listing->pickup_from->format('d M, H:i') }}
                                        – {{ $listing->pickup_until->format('H:i') }}
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="flex flex-col gap-3 border-t border-[#EAD8CD] pt-5 lg:w-72 lg:shrink-0 lg:border-l lg:border-t-0 lg:pl-6 lg:pt-0">
                            @if (auth()->user()->isRecipient())
                                <div class="rounded-2xl bg-[#FFF8F2] px-5 py-4 text-center">
                                    <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#A18F84]">
                                        Your pickup code
                                    </p>

                                    <p class="brand-font mt-2 text-2xl font-extrabold tracking-[0.2em] text-[#4A342B]">
                                        {{ $pickup->pickup_code }}
                                    </p>

                                    <p class="mt-1 text-xs text-[#88766D]">
                                        Show this code to the donor.
                                    </p>
                                </div>
                            @endif
                            @if ($pickup->status === \App\Enums\PickupStatus::PENDING)

                                @can('confirm', $pickup)

                                    <form method="POST"
                                          action="{{ route('pickups.confirm', $pickup) }}"
                                          class="space-y-3">

                                        @csrf

                                        <input type="hidden" name="pickup_id" value="{{ $pickup->id }}">

                                        <div>
                                            <label for="pickup_code_{{ $pickup->id }}"
                                                   class="mb-2 block text-xs font-bold text-[#806F66]">
                                                Enter recipient's pickup code
                                            </label>

                                            <input type="text"
                                                   id="pickup_code_{{ $pickup->id }}"
                                                   name="pickup_code"
                                                   placeholder="ABCD-1234"
                                                   value="{{ old('pickup_id') == $pickup->id ? old('pickup_code') : '' }}"
                                                   class="w-full rounded-xl border border-[#EAD8CD] bg-[#FFF8F2] px-4 py-3 text-sm text-[#4A342B] outline-none transition focus:border-[#E9A17D] focus:ring-2 focus:ring-[#E9A17D]/30">
                                        </div>

                                        @if (old('pickup_id') == $pickup->id)
                                            @error('pickup_code')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        @endif

                                        <button type="submit"
                                                class="w-full rounded-full bg-[#E9A17D] px-5 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                                            Confirm pickup
                                        </button>

                                    </form>

                                @endcan

                            @elseif ($pickup->status === \App\Enums\PickupStatus::COLLECTED)

                                <div class="rounded-2xl bg-[#E8F3E8] px-5 py-4">
                                    <p class="text-sm font-bold text-[#47764B]">
                                        Successfully collected
                                    </p>

                                    <p class="mt-1 text-xs text-[#638267]">
                                        {{ $pickup->collected_at?->format('d M, H:i') }}
                                    </p>

                                    @if ($pickup->confirmedBy)
                                        <p class="mt-1 text-xs text-[#638267]">
                                            Confirmed by {{ $pickup->confirmedBy->name }}
                                        </p>
                                    @endif
                                </div>

                            @endif

                        </div>

                    </div>
                </article>

            @empty

                <div class="rounded-3xl border border-[#EAD8CD] bg-white px-6 py-16 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#8E583D]">
                        <x-heroicon-o-calendar class="h-8 w-8" />
                    </div>

                    <h2 class="brand-font mt-5 text-2xl font-extrabold text-[#4A342B]">
                        No pickups yet
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#88766D]">
                        A pickup record will appear here when food is reserved.
                    </p>

                </div>

            @endforelse

        </div>

        @if ($pickups->hasPages())
            <div class="mt-10">
                {{ $pickups->links() }}
            </div>
        @endif

    </section>

</x-layouts.public>

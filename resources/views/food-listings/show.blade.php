<x-layouts.public :title="$listing->title . ' - FoodLoop'">
    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <a href="{{ route('food-listings.index') }}"
           class="text-sm font-semibold text-[#B96F4D] hover:underline">
            &larr; Back to all food
        </a>
        <div class="mt-6 grid gap-10 lg:grid-cols-[1.2fr_1fr]">
            <div class="overflow-hidden rounded-[2rem] bg-[#F1D8C8] p-3 shadow-xl shadow-[#4A342B]/10">
                <img
                    src="{{ $listing->photoUrl() }}"
                    alt="{{ $listing->title }}"
                    class="h-[320px] w-full rounded-[1.5rem] object-cover sm:h-[460px]">
            </div>
            <div>
                <span class="rounded-full bg-[#F7E8DE] px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-[#8E583D]">
                    {{ $listing->foodCategory->name }}
                </span>

                <h1 class="brand-font mt-5 text-4xl font-extrabold tracking-tight text-[#4A342B]">
                    {{ $listing->title }}
                </h1>
                <p class="mt-2 text-[#88766D]">
                    Shared by <strong>{{ $listing->organization->name }}</strong>
                    @if ($listing->organization->city)
                        in {{ $listing->organization->city }}
                    @endif
                </p>
                @if ($listing->description)
                    <p class="mt-6 leading-7 text-[#6B5A51]">
                        {{ $listing->description }}
                    </p>
                @endif
                <dl class="mt-8 grid grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                        <dt class="text-xs text-[#A18F84]">Quantity</dt>
                        <dd class="mt-1 text-xl font-extrabold text-[#4A342B]">{{ $listing->quantity }}</dd>
                    </div>
                    <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                        <dt class="text-xs text-[#A18F84]">Status</dt>
                        <dd class="mt-1 text-xl font-extrabold capitalize text-[#4A342B]">{{ $listing->status->value }}</dd>
                    </div>
                    <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                        <dt class="text-xs text-[#A18F84]">Pickup from</dt>
                        <dd class="mt-1 font-bold text-[#4A342B]">{{ $listing->pickup_from->format('d M Y, H:i') }}</dd>
                    </div>
                    <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                        <dt class="text-xs text-[#A18F84]">Pickup until</dt>
                        <dd class="mt-1 font-bold text-[#4A342B]">{{ $listing->pickup_until->format('d M Y, H:i') }}</dd>
                    </div>
                </dl>
                <p class="mt-4 text-sm text-[#88766D]">
                    Best before {{ $listing->expires_at->format('d M Y, H:i') }}
                </p>
                <div class="mt-8">
                    @guest
                        <a href="{{ route('login') }}"
                        class="inline-flex rounded-full bg-[#E9A17D] px-8 py-4 text-sm font-bold text-[#4A342B] transition hover:-translate-y-1 hover:bg-[#D98E69]">
                            Log in to reserve this food
                        </a>
                    @else
                        @if (! auth()->user()->isRecipient())
                            <p class="rounded-2xl bg-[#F7E8DE] px-5 py-4 text-sm text-[#8E583D]">
                                Only recipient accounts (charities) can reserve food.
                            </p>
                        @elseif (! auth()->user()->hasActiveOrganization())
                            <div class="rounded-2xl bg-[#F7E8DE] px-5 py-4 text-sm text-[#8E583D]">
                                You need an active organization before you can reserve food.
                                <a href="{{ route('organizations.create') }}" class="font-bold underline">Create your organization</a>
                            </div>
                        @elseif (! $listing->isReservable())
                            <p class="rounded-2xl bg-[#F7E8DE] px-5 py-4 text-sm text-[#8E583D]">
                                This food cannot be reserved right now.
                            </p>
                        @else
                            <form method="POST" action="{{ route('reservations.store', $listing) }}"
                                class="rounded-2xl border border-[#EAD8CD] bg-white p-6">
                                @csrf

                                <label for="quantity" class="text-sm font-bold text-[#4A342B]">
                                    How many do you need?
                                </label>
                                <p class="text-xs text-[#A18F84]">
                                    {{ $listing->remainingQuantity() }} still available
                                </p>

                                <input type="number"
                                    id="quantity"
                                    name="quantity"
                                    min="1"
                                    max="{{ $listing->remainingQuantity() }}"
                                    value="{{ old('quantity', 1) }}"
                                    class="mt-3 w-full rounded-full border border-[#EAD8CD] bg-[#FFF8F2] px-5 py-3 text-sm focus:border-[#E9A17D] focus:outline-none focus:ring-2 focus:ring-[#E9A17D]/40">

                                @error('quantity')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <button type="submit"
                                        class="mt-4 w-full rounded-full bg-[#E9A17D] px-8 py-4 text-sm font-bold text-[#4A342B] transition hover:-translate-y-0.5 hover:bg-[#D98E69]">
                                    Reserve this food
                                </button>
                            </form>
                        @endif
                    @endguest
                </div>
            </div>

        </div>
    </section>

</x-layouts.public>
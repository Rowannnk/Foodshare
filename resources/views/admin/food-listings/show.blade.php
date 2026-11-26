
<x-layouts.admin :title="$listing->title . ' - Admin - FoodLoop'">

    <div class="mx-auto max-w-7xl space-y-8 px-6 py-10 lg:px-8">
        <a href="{{ route('admin.food-listings.index') }}"
           class="inline-flex items-center gap-2 text-sm font-bold text-[#B96F4D] transition hover:text-[#4A342B]">
            <x-heroicon-o-arrow-left class="h-4 w-4" />
            Back to Food Listings
        </a>
        @if (session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-700">
                {{ session('success') }}
            </div>
        @endif
        <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-start">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                    Food Listing Details
                </p>

                <div class="mt-3 flex flex-wrap items-center gap-3">
                    <h1 class="brand-font text-3xl font-extrabold tracking-tight text-[#4A342B] sm:text-4xl">
                        {{ $listing->title }}
                    </h1>

                    <span class="inline-flex rounded-full bg-[#F7E8DE] px-3 py-1.5 text-xs font-bold capitalize text-[#8E583D]">
                        {{ str_replace('_', ' ', $listing->status->value) }}
                    </span>
                </div>

                <p class="mt-2 text-sm text-[#88766D]">
                    {{ $listing->foodCategory->name }}
                    <span class="mx-1">&middot;</span>
                    {{ $listing->organization->name }}
                </p>

                <p class="mt-1 text-xs text-[#A18F84]">
                    Listing #{{ $listing->id }}
                </p>
            </div>

            <a href="{{ route('admin.food-listings.edit', $listing) }}"
               class="inline-flex w-fit items-center justify-center gap-2 rounded-xl bg-[#4A342B] px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#765748]">
                <x-heroicon-o-pencil-square class="h-4 w-4" />
                Edit Listing
            </a>
        </section>
        <section class="grid gap-6 lg:grid-cols-5">

            <div class="overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white lg:col-span-2">
                <img
                    src="{{ $listing->photoUrl() }}"
                    alt="{{ $listing->title }}"
                    class="h-64 w-full object-cover sm:h-80 lg:h-full lg:min-h-[320px]"
                >
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-6 lg:col-span-3">
                <h2 class="font-bold text-[#4A342B]">
                    Listing Description
                </h2>

                @if ($listing->description)
                    <p class="mt-4 whitespace-pre-line text-sm leading-7 text-[#6B5A51]">
                        {{ $listing->description }}
                    </p>
                @else
                    <p class="mt-4 text-sm italic text-[#A18F84]">
                        No description provided.
                    </p>
                @endif

                <div class="mt-6 border-t border-[#F1E6DE] pt-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#A18F84]">
                        Food Category
                    </p>

                    <p class="mt-2 font-semibold text-[#4A342B]">
                        {{ $listing->foodCategory->name }}
                    </p>
                </div>
            </div>

        </section>
        <section class="rounded-2xl border border-[#EAD8CD] bg-white p-6">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-wider text-[#B96F4D]">
                        Provided By
                    </p>

                    <h2 class="mt-2 text-xl font-extrabold text-[#4A342B]">
                        {{ $listing->organization->name }}
                    </h2>
                </div>

                <a href="{{ route('admin.organizations.show', $listing->organization) }}"
                   class="inline-flex w-fit items-center gap-2 rounded-xl border border-[#EAD8CD] px-4 py-2.5 text-sm font-bold text-[#806F66] transition hover:bg-[#FFF8F2] hover:text-[#4A342B]">
                    View Organization
                    <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                </a>
            </div>
        </section>
        <section>
            <div class="mb-4">
                <h2 class="font-bold text-[#4A342B]">
                    Listing Information
                </h2>

                <p class="mt-1 text-xs text-[#A18F84]">
                    Quantity and collection details.
                </p>
            </div>

            <dl class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                    <dt class="text-sm font-semibold text-[#88766D]">
                        Total Quantity
                    </dt>

                    <dd class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                        {{ $listing->quantity }}
                    </dd>

                    <p class="mt-2 text-xs text-[#A18F84]">
                        Originally listed items
                    </p>
                </div>

                <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                    <dt class="text-sm font-semibold text-[#88766D]">
                        Still Available
                    </dt>

                    <dd class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                        {{ $listing->remainingQuantity() }}
                    </dd>

                    <p class="mt-2 text-xs text-[#A18F84]">
                        Items remaining for reservation
                    </p>
                </div>

                <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                    <dt class="text-sm font-semibold text-[#88766D]">
                        Pickup Window
                    </dt>

                    <dd class="mt-3 text-base font-extrabold text-[#4A342B]">
                        {{ $listing->pickup_from->format('d M, H:i') }}
                    </dd>

                    <p class="mt-2 text-xs text-[#A18F84]">
                        Until {{ $listing->pickup_until->format('d M, H:i') }}
                    </p>
                </div>

                <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                    <dt class="text-sm font-semibold text-[#88766D]">
                        Best Before
                    </dt>

                    <dd class="mt-3 text-base font-extrabold text-[#4A342B]">
                        {{ $listing->expires_at->format('d M, H:i') }}
                    </dd>

                    <p class="mt-2 text-xs text-[#A18F84]">
                        Listing expiry date
                    </p>
                </div>

            </dl>
        </section>
        <section class="overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white">

            <div class="flex flex-col justify-between gap-2 border-b border-[#EAD8CD] px-6 py-5 sm:flex-row sm:items-center">
                <div>
                    <h2 class="font-bold text-[#4A342B]">
                        Reservations
                    </h2>

                    <p class="mt-1 text-xs text-[#A18F84]">
                        Recipients who have reserved this food listing.
                    </p>
                </div>

                <span class="w-fit rounded-lg bg-[#FFF8F2] px-3 py-2 text-xs font-bold text-[#806F66]">
                    {{ $listing->reservations->count() }} reservations
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left text-sm">

                    <thead class="bg-[#FFF8F2] text-[11px] font-extrabold uppercase tracking-wider text-[#A18F84]">
                        <tr>
                            <th class="px-6 py-4">Recipient</th>
                            <th class="px-6 py-4">Quantity</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Reserved At</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#F1E6DE]">

                        @forelse ($listing->reservations as $reservation)
                            <tr class="transition hover:bg-[#FFFCF9]">

                                <td class="px-6 py-5">
                                    <span class="font-bold text-[#4A342B]">
                                        {{ $reservation->user->name }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 font-semibold text-[#4A342B]">
                                    {{ $reservation->quantity }}
                                </td>

                                <td class="px-6 py-5">
                                    <span class="inline-flex rounded-full bg-[#F7E8DE] px-3 py-1.5 text-xs font-bold capitalize text-[#8E583D]">
                                        {{ str_replace('_', ' ', $reservation->status->value) }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-[#88766D]">
                                    {{ $reservation->reserved_at?->format('d M Y, H:i') ?? '—' }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#B96F4D]">
                                        <x-heroicon-o-calendar-days class="h-7 w-7" />
                                    </span>

                                    <h3 class="mt-4 font-bold text-[#4A342B]">
                                        No reservations yet
                                    </h3>

                                    <p class="mt-1 text-sm text-[#88766D]">
                                        Reservations for this listing will appear here.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.admin>

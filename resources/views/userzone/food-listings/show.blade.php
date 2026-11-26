<x-layouts.public :title="$listing->title . ' - FoodLoop'">

    <section class="mx-auto max-w-5xl px-6 py-12 lg:px-8">

        <a href="{{ route('my-listings.index') }}" class="text-sm font-semibold text-[#B96F4D] hover:underline">
            &larr; Back to my listings
        </a>

        <div class="mt-5 flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
            <div>
                <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-extrabold uppercase tracking-widest text-[#8E583D]">
                    {{ $listing->status->value }}
                </span>
                <h1 class="brand-font mt-4 text-4xl font-extrabold tracking-tight text-[#4A342B]">
                    {{ $listing->title }}
                </h1>
                <p class="mt-2 text-[#88766D]">
                    {{ $listing->foodCategory->name }} &middot; {{ $listing->organization->name }}
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('my-listings.edit', $listing) }}"
                   class="rounded-full bg-[#E9A17D] px-6 py-3 text-sm font-bold text-[#4A342B] hover:bg-[#D98E69]">
                    Edit
                </a>
                <a href="{{ route('food-listings.show', $listing) }}"
                   class="rounded-full border border-[#EAD8CD] px-6 py-3 text-sm font-semibold text-[#806F66] hover:bg-[#FFF3EB]">
                    Public page
                </a>
            </div>
        </div>

        <img src="{{ $listing->photoUrl() }}" alt="{{ $listing->title }}" class="mt-6 h-64 w-full rounded-[1.75rem] object-cover sm:h-80">

        @if ($listing->description)
            <p class="mt-6 max-w-2xl leading-7 text-[#6B5A51]">{{ $listing->description }}</p>
        @endif

        <dl class="mt-8 grid gap-4 sm:grid-cols-4">
            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <dt class="text-xs text-[#A18F84]">Total quantity</dt>
                <dd class="mt-1 text-xl font-extrabold">{{ $listing->quantity }}</dd>
            </div>
            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <dt class="text-xs text-[#A18F84]">Still available</dt>
                <dd class="mt-1 text-xl font-extrabold">{{ $listing->remainingQuantity() }}</dd>
            </div>
            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <dt class="text-xs text-[#A18F84]">Pickup</dt>
                <dd class="mt-1 text-sm font-bold">
                    {{ $listing->pickup_from->format('d M, H:i') }} - {{ $listing->pickup_until->format('H:i') }}
                </dd>
            </div>
            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <dt class="text-xs text-[#A18F84]">Best before</dt>
                <dd class="mt-1 text-sm font-bold">{{ $listing->expires_at->format('d M, H:i') }}</dd>
            </div>
        </dl>

        <h2 class="brand-font mt-12 text-2xl font-extrabold text-[#4A342B]">Reservations</h2>

        <div class="mt-4 overflow-x-auto rounded-[1.5rem] border border-[#EAD8CD] bg-white">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#EAD8CD] bg-[#FFF8F2] text-xs uppercase tracking-widest text-[#A18F84]">
                    <tr>
                        <th class="px-6 py-4">Recipient</th>
                        <th class="px-6 py-4">Quantity</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Reserved at</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAD8CD]">
                    @forelse ($listing->reservations as $reservation)
                        <tr>
                            <td class="px-6 py-4 font-semibold">{{ $reservation->user->name }}</td>
                            <td class="px-6 py-4">{{ $reservation->quantity }}</td>
                            <td class="px-6 py-4 capitalize">{{ $reservation->status->value }}</td>
                            <td class="px-6 py-4 text-[#88766D]">{{ $reservation->reserved_at->format('d M, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-[#88766D]">
                                No reservations yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</x-layouts.public>
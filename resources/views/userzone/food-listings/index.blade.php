<x-layouts.public title="My listings - FoodLoop">
    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-6 px-6 py-12 sm:flex-row sm:items-center lg:px-8">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                    {{ auth()->user()->isAdmin() ? 'All listings' : 'Your food sharing' }}
                </p>
                <h1 class="brand-font mt-3 text-4xl font-extrabold text-[#4A342B] sm:text-5xl">
                    My listings
                </h1>
                <p class="mt-2 text-sm text-[#88766D]">
                    Manage your food listings and track their reservations.
                </p>
            </div>

            <a href="{{ route('my-listings.create') }}"
               class="w-fit rounded-full bg-[#E9A17D] px-7 py-3 font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                + New listing
            </a>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

        @error('listing')
            <p class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                {{ $message }}
            </p>
        @enderror

        @if ($listings->isEmpty())
            <div class="rounded-3xl border border-dashed border-[#EAD8CD] bg-white px-6 py-16 text-center">
                <x-heroicon-o-shopping-bag class="mx-auto h-12 w-12 text-[#B96F4D]" />
                <h2 class="brand-font mt-4 text-xl font-extrabold text-[#4A342B]">
                    No listings yet
                </h2>
                <p class="mt-2 text-sm text-[#88766D]">
                    Share your surplus food with your first listing.
                </p>
            </div>
        @else
            <div class="mb-6 flex items-center justify-between">
                <p class="text-sm text-[#88766D]">
                    Showing <span class="font-bold text-[#4A342B]">{{ $listings->count() }}</span>
                    of <span class="font-bold text-[#4A342B]">{{ $listings->total() }}</span> listings
                </p>
            </div>            
            <div class="space-y-5">
                @foreach ($listings as $listing)
                    <div class="group overflow-hidden rounded-3xl border border-[#EAD8CD] bg-white transition hover:border-[#D9B69F] hover:shadow-lg hover:shadow-[#4A342B]/5">
                        <a href="{{ route('my-listings.show', $listing) }}"
                        class="block p-5 sm:p-6">

                            <div class="flex flex-col gap-5 sm:flex-row">
                                <div class="shrink-0 overflow-hidden rounded-2xl bg-[#FFF8F2] sm:w-48">
                                    <x-listing-thumb :listing="$listing" size="h-40 w-full" />
                                </div>
                                <div class="flex min-w-0 flex-1 flex-col justify-between gap-4">
                                    <div>
                                        <div class="flex flex-wrap items-center justify-between gap-3">
                                            <span class="text-xs font-bold uppercase tracking-widest text-[#B96F4D]">
                                                {{ $listing->foodCategory->name }}
                                            </span>

                                            <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-bold capitalize text-[#8E583D]">
                                                {{ $listing->status->value }}
                                            </span>
                                        </div>

                                        <h2 class="brand-font mt-3 text-xl font-extrabold text-[#4A342B] transition group-hover:text-[#B96F4D]">
                                            {{ $listing->title }}
                                        </h2>

                                        <p class="mt-2 text-sm text-[#88766D]">
                                            {{ $listing->organization->name }}
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap gap-3">
                                        <div class="rounded-xl bg-[#FFF8F2] px-4 py-3">
                                            <p class="text-xs text-[#88766D]">Quantity</p>
                                            <p class="mt-1 font-extrabold text-[#4A342B]">
                                                {{ $listing->quantity }} items
                                            </p>
                                        </div>

                                        <div class="rounded-xl bg-[#FFF8F2] px-4 py-3">
                                            <p class="text-xs text-[#88766D]">Reservations</p>
                                            <p class="mt-1 font-extrabold text-[#4A342B]">
                                                {{ $listing->reservations_count }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="flex items-center justify-between border-t border-[#EAD8CD] bg-[#FFFCF9] px-5 py-4 sm:px-6">
                            <a href="{{ route('my-listings.show', $listing) }}"
                            class="text-sm font-bold text-[#88766D] transition hover:text-[#B96F4D]">
                                View details →
                            </a>

                            <div class="flex items-center gap-5">
                                <a href="{{ route('my-listings.edit', $listing) }}"
                                class="text-sm font-bold text-[#B96F4D] transition hover:underline">
                                    Edit
                                </a>

                                <form method="POST"
                                    action="{{ route('my-listings.destroy', $listing) }}"
                                    onsubmit="return confirm('Delete this listing?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-sm font-bold text-red-600 transition hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
            <div class="mt-10">
                {{ $listings->links() }}
            </div>

        @endif
    </section>

</x-layouts.public>

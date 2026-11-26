<x-layouts.public title="My listings - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-6 px-6 py-14 sm:flex-row sm:items-end lg:px-8">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                    {{ auth()->user()->isAdmin() ? 'All organizations' : 'Your organizations' }}
                </p>
                <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                    My listings
                </h1>
            </div>

            <a href="{{ route('my-listings.create') }}"
               class="w-fit rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                + New listing
            </a>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        @error('listing')
            <p class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                {{ $message }}
            </p>
        @enderror

        @if ($listings->isEmpty())
            <div class="rounded-3xl border border-[#EAD8CD] bg-white px-6 py-16 text-center">
                <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">No listings yet</h2>
                <p class="mt-2 text-sm text-[#88766D]">Share your surplus food with a first listing.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-[1.5rem] border border-[#EAD8CD] bg-white">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-[#EAD8CD] bg-[#FFF8F2] text-xs uppercase tracking-widest text-[#A18F84]">
                        <tr>
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Organization</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Qty</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Reservations</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EAD8CD]">
                        @foreach ($listings as $listing)
                            <tr>
                                <td class="px-6 py-4 font-semibold text-[#4A342B]">
                                    <a href="{{ route('my-listings.show', $listing) }}" class="flex items-center gap-3 hover:underline">
                                        <x-listing-thumb :listing="$listing" />
                                        {{ $listing->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-[#88766D]">{{ $listing->organization->name }}</td>
                                <td class="px-6 py-4 text-[#88766D]">{{ $listing->foodCategory->name }}</td>
                                <td class="px-6 py-4">{{ $listing->quantity }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-bold capitalize text-[#8E583D]">
                                        {{ $listing->status->value }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $listing->reservations_count }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('my-listings.edit', $listing) }}"
                                           class="font-semibold text-[#B96F4D] hover:underline">Edit</a>

                                        <form method="POST" action="{{ route('my-listings.destroy', $listing) }}"
                                              onsubmit="return confirm('Delete this listing?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-semibold text-red-600 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-10">
                {{ $listings->links() }}
            </div>
        @endif
    </section>

</x-layouts.public>
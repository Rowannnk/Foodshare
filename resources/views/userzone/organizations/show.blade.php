<x-layouts.public :title="$organization->name . ' - FoodLoop'">

    <section class="mx-auto max-w-5xl px-6 py-12 lg:px-8">

        <a href="{{ route('organizations.index') }}" class="text-sm font-semibold text-[#B96F4D] hover:underline">
            &larr; Back to organizations
        </a>

        <div class="mt-5 flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
            <div>
                <div class="flex items-center gap-2">
                    <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-extrabold uppercase tracking-widest text-[#8E583D]">
                        {{ $organization->type->value }}
                    </span>
                    @unless ($organization->is_active)
                        <span class="rounded-full bg-stone-100 px-3 py-1 text-xs font-bold text-stone-500">Inactive</span>
                    @endunless
                </div>

                <h1 class="brand-font mt-4 text-4xl font-extrabold tracking-tight text-[#4A342B]">
                    {{ $organization->name }}
                </h1>
                <p class="mt-2 text-[#88766D]">Owner: {{ $organization->user->name }}</p>
            </div>

            @if ($canManage)
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('organizations.edit', $organization) }}"
                    class="w-fit rounded-full bg-[#E9A17D] px-6 py-3 text-sm font-bold text-[#4A342B] hover:bg-[#D98E69]">
                        Edit
                    </a>

                    <form method="POST"
                        action="{{ route('organizations.destroy', $organization) }}"
                        onsubmit="return confirm('Are you sure you want to delete this organization?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="w-fit rounded-full border border-red-200 bg-red-50 px-6 py-3 text-sm font-bold text-red-600 transition hover:bg-red-100">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <dl class="mt-8 grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <dt class="text-xs text-[#A18F84]">Email</dt>
                <dd class="mt-1 font-bold">{{ $organization->contact_email ?? '-' }}</dd>
            </div>
            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <dt class="text-xs text-[#A18F84]">Phone</dt>
                <dd class="mt-1 font-bold">{{ $organization->contact_phone ?? '-' }}</dd>
            </div>
            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <dt class="text-xs text-[#A18F84]">Address</dt>
                <dd class="mt-1 font-bold">
                    {{ $organization->address ?? '-' }}@if ($organization->city), {{ $organization->city }}@endif
                </dd>
            </div>
        </dl>

        <h2 class="brand-font mt-12 text-2xl font-extrabold text-[#4A342B]">
            {{ $canManage ? 'All listings' : 'Available food' }}
        </h2>

        <div class="mt-4 space-y-3">
            @forelse ($listings as $listing)
                <a href="{{ route('food-listings.show', $listing) }}"
                   class="flex items-center justify-between rounded-2xl border border-[#EAD8CD] bg-white p-5 transition hover:shadow-lg">
                   <div class="flex items-center gap-4">
                        <x-listing-thumb :listing="$listing" />
                        <div>
                            <p class="font-bold text-[#4A342B]">{{ $listing->title }}</p>
                            <p class="text-sm text-[#88766D]">
                                {{ $listing->foodCategory->name }} &middot; {{ $listing->quantity }} items
                            </p>
                        </div>
                   </div>
                    <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-bold capitalize text-[#8E583D]">
                        {{ $listing->status->value }}
                    </span>
                </a>
            @empty
                <p class="rounded-2xl border border-[#EAD8CD] bg-white px-6 py-10 text-center text-[#88766D]">
                    No food listings yet.
                </p>
            @endforelse
        </div>
    </section>

</x-layouts.public>
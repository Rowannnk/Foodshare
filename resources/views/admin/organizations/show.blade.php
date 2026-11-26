<x-layouts.admin :title="$organization->name . ' - Admin - FoodLoop'">

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        <a href="{{ route('admin.organizations.index') }}"
           class="text-sm font-semibold text-[#B96F4D] hover:underline">
            &larr; Back to organizations
        </a>

        <div class="mt-6 flex flex-col justify-between gap-6 sm:flex-row sm:items-start">

            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-extrabold uppercase tracking-widest text-[#8E583D]">
                        {{ $organization->type->value }}
                    </span>

                    @if ($organization->is_active)
                        <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                            Active
                        </span>
                    @else
                        <span class="rounded-full bg-stone-100 px-3 py-1 text-xs font-bold text-stone-500">
                            Inactive
                        </span>
                    @endif
                </div>

                <h1 class="brand-font mt-4 text-4xl font-extrabold tracking-tight text-[#4A342B]">
                    {{ $organization->name }}
                </h1>

                <p class="mt-2 text-[#88766D]">
                    Owner: {{ $organization->user->name }}
                </p>
                <p class="text-sm text-[#88766D]">
                    {{ $organization->user->email }}
                </p>
            </div>

            <a href="{{ route('admin.organizations.edit', $organization) }}"
               class="w-fit rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                Edit organization
            </a>

        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#A18F84]">
                    Contact email
                </p>
                <p class="mt-2 break-words font-bold text-[#4A342B]">
                    {{ $organization->contact_email ?? '-' }}
                </p>
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#A18F84]">
                    Contact phone
                </p>
                <p class="mt-2 font-bold text-[#4A342B]">
                    {{ $organization->contact_phone ?? '-' }}
                </p>
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#A18F84]">
                    Address
                </p>
                <p class="mt-2 font-bold text-[#4A342B]">
                    {{ $organization->address ?? '-' }}
                </p>
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#A18F84]">
                    City
                </p>
                <p class="mt-2 font-bold text-[#4A342B]">
                    {{ $organization->city ?? '-' }}
                </p>
            </div>

        </div>

        <div class="mt-12">
            <h2 class="brand-font text-2xl font-extrabold text-[#4A342B]">
                Food listings
            </h2>

            <p class="mt-2 text-sm text-[#88766D]">
                Food listings published by this organization.
            </p>
        </div>

        <div class="mt-5 space-y-3">
            @forelse ($listings as $listing)
                <div class="flex flex-col justify-between gap-4 rounded-2xl border border-[#EAD8CD] bg-white p-5 sm:flex-row sm:items-center">

                    <div class="flex items-center gap-4">
                        <x-listing-thumb :listing="$listing" />

                        <div>
                            <p class="font-bold text-[#4A342B]">
                                {{ $listing->title }}
                            </p>

                            <p class="mt-1 text-sm text-[#88766D]">
                                {{ $listing->foodCategory->name }}
                                &middot;
                                {{ $listing->quantity }} items
                            </p>
                        </div>
                    </div>

                    <span class="w-fit rounded-full bg-[#F7E8DE] px-3 py-1 text-xs font-bold capitalize text-[#8E583D]">
                        {{ $listing->status->value }}
                    </span>

                </div>
            @empty
                <p class="rounded-2xl border border-[#EAD8CD] bg-white px-6 py-10 text-center text-[#88766D]">
                    This organization has no food listings yet.
                </p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $listings->links() }}
        </div>

    </section>

</x-layouts.admin>

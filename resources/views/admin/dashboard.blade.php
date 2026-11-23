<x-layouts.public title="Admin - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                Admin only
            </p>
            <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                Platform overview
            </h1>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ([
                'Users' => $userCount,
                'Organizations' => $organizationCount,
                'Categories' => $categoryCount,
                'Listings' => $listingCount,
                'Reservations' => $reservationCount,
            ] as $label => $count)
                <div class="rounded-2xl border border-[#EAD8CD] bg-white p-6 text-center">
                    <p class="brand-font text-3xl font-extrabold text-[#C77D56]">{{ $count }}</p>
                    <p class="mt-1 text-sm text-[#88766D]">{{ $label }}</p>
                </div>
            @endforeach
        </div>

        <h2 class="brand-font mt-12 text-2xl font-extrabold text-[#4A342B]">Manage</h2>

        <div class="mt-4 grid gap-6 md:grid-cols-3">
            <a href="{{ route('admin.categories.index') }}"
               class="rounded-[1.75rem] border border-[#E9A17D]/40 bg-[#F7E8DE] p-8 transition hover:-translate-y-1 hover:shadow-xl">
                <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">Food categories</h3>
                <p class="mt-2 text-sm text-[#806B60]">Add, edit or deactivate categories.</p>
            </a>

            <a href="{{ route('organizations.index') }}"
               class="rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8 transition hover:-translate-y-1 hover:shadow-xl">
                <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">Organizations</h3>
                <p class="mt-2 text-sm text-[#88766D]">See and manage all organizations.</p>
            </a>

            <a href="{{ route('my-listings.index') }}"
               class="rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8 transition hover:-translate-y-1 hover:shadow-xl">
                <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">Food listings</h3>
                <p class="mt-2 text-sm text-[#88766D]">See and manage all food listings.</p>
            </a>
        </div>
    </section>

</x-layouts.public>
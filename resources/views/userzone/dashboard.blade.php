<x-layouts.public title="Dashboard - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                Welcome back
            </p>

            <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                Hello, {{ auth()->user()->name }}
            </h1>

            <p class="mt-3 text-[#88766D]">
                You are logged in as
                <strong class="capitalize">{{ auth()->user()->role->value }}</strong>.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

            <a href="{{ route('food-listings.index') }}"
               class="rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8 transition hover:-translate-y-1 hover:shadow-xl">
                <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">Browse food</h2>
                <p class="mt-2 text-sm text-[#88766D]">See all the food that is available right now.</p>
            </a>

            @if (auth()->user()->isRecipient())
                <a href="{{ route('reservations.index') }}"
                   class="rounded-[1.75rem] border border-[#E9A17D]/40 bg-[#F7E8DE] p-8 transition hover:-translate-y-1 hover:shadow-xl">
                    <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">My reservations</h2>
                    <p class="mt-2 text-sm text-[#806B60]">Check your pickup codes and cancel a reservation.</p>
                </a>
            @endif

            @if (auth()->user()->isDonor() || auth()->user()->isAdmin())
                <a href="{{ route('my-listings.index') }}"
                   class="rounded-[1.75rem] border border-[#E9A17D]/40 bg-[#F7E8DE] p-8 transition hover:-translate-y-1 hover:shadow-xl">
                    <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">My listings</h2>
                    <p class="mt-2 text-sm text-[#806B60]">Publish surplus food and see who reserved it.</p>
                </a>
            @endif

            <a href="{{ route('organizations.index') }}"
                class="rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8 transition hover:-translate-y-1 hover:shadow-xl">
                <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">Organizations</h2>
                <p class="mt-2 text-sm text-[#88766D]">Create and manage your organizations.</p>
            </a>

            @if (auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                class="rounded-[1.75rem] border border-[#E9A17D]/40 bg-[#F7E8DE] p-8 transition hover:-translate-y-1 hover:shadow-xl">
                    <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">Admin</h2>
                    <p class="mt-2 text-sm text-[#806B60]">Manage categories and see the platform numbers.</p>
                </a>
            @endif

            <a href="{{ route('pickups.index') }}"
            class="rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8 transition hover:-translate-y-1 hover:shadow-xl">
                <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">Pickups</h2>
                <p class="mt-2 text-sm text-[#88766D]">Check pickup codes and confirm collected food.</p>
            </a>

            <a href="{{ route('profile.edit') }}"
                class="rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8 transition hover:-translate-y-1 hover:shadow-xl">
                <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">My profile</h2>
                <p class="mt-2 text-sm text-[#88766D]">Change your name, email or password.</p>
            </a>

        </div>
    </section>

</x-layouts.public>
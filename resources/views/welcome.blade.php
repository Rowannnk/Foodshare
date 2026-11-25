<x-layouts.public title="FoodLoop - Fresh food, shared with purpose">

    <section id="home" class="overflow-hidden">

        <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:px-8 lg:py-24">

            <div>

            <h1 class="brand-font mt-8 text-5xl font-extrabold leading-[1.08] tracking-tight text-[#4A342B] sm:text-6xl lg:text-7xl">
                Share more.
                <span class="block text-[#C77D56]">Waste less.</span>
            </h1>

            <p class="mt-7 max-w-lg text-lg leading-8 text-[#88766D]">
                FoodLoop connects food businesses with charities, so surplus food
                reaches people who need it instead of the bin.
            </p>

            <div class="mt-9 flex flex-wrap gap-4">
                @guest
                    <a href="{{ route('register') }}"
                       class="rounded-full bg-[#E9A17D] px-8 py-4 text-sm font-bold text-[#4A342B] shadow-lg shadow-[#E9A17D]/30 transition hover:-translate-y-1 hover:bg-[#D98E69]">
                        Join FoodLoop
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="rounded-full bg-[#E9A17D] px-8 py-4 text-sm font-bold text-[#4A342B] shadow-lg shadow-[#E9A17D]/30 transition hover:-translate-y-1 hover:bg-[#D98E69]">
                        Go to dashboard
                    </a>
                @endguest

                <a href="{{ route('food-listings.index') }}"
                   class="rounded-full border border-[#EAD8CD] bg-white px-8 py-4 text-sm font-bold text-[#4A342B] transition hover:border-[#E9A17D] hover:bg-[#FFF3EB]">
                    Browse available food
                </a>
            </div>

            <ul class="mt-10 grid max-w-lg gap-3 text-sm font-semibold text-[#6B5A51] sm:grid-cols-3">
                <li class="flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#F7E8DE] text-xs text-[#B96F4D]">✓</span>
                    Simple reservations
                </li>
                <li class="flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#F7E8DE] text-xs text-[#B96F4D]">✓</span>
                    Pickup with a code
                </li>
                <li class="flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#F7E8DE] text-xs text-[#B96F4D]">✓</span>
                    Less food waste
                </li>
            </ul>
        </div>

            <div class="relative">

                <div class="absolute -right-8 -top-8 h-40 w-40 rounded-full bg-[#F1D8C8] blur-2xl"></div>

                <div class="relative overflow-hidden rounded-[2rem] bg-[#F1D8C8] p-3 shadow-xl shadow-[#4A342B]/10">

                    <img
                        src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=1200&q=85"
                        alt="Fresh food and vegetables prepared for sharing"
                        class="h-[420px] w-full rounded-[1.5rem] object-cover sm:h-[520px]"
                    >

                    <div class="absolute bottom-8 left-8 right-8 rounded-2xl border border-white/50 bg-white/90 p-6 shadow-lg backdrop-blur-md sm:bottom-10 sm:left-10 sm:right-10">

                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#B96F4D]">
                            The FoodLoop mission
                        </p>

                        <h2 class="brand-font mt-2 text-2xl font-extrabold text-[#4A342B] sm:text-3xl">
                            Give good food a second life.
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-[#88766D]">
                            Bringing surplus food and people together.
                        </p>

                    </div>

                </div>

                <div class="absolute -bottom-5 -right-3 rounded-2xl bg-[#E9A17D] px-6 py-4 shadow-lg sm:-right-5">
                    <p class="text-xs font-bold uppercase tracking-widest text-[#704A3A]">
                        Our purpose
                    </p>
                    <p class="mt-1 font-extrabold text-[#4A342B]">
                        Less waste. More meals.
                    </p>
                </div>

            </div>

        </div>

    </section>


    <section class="mx-auto max-w-7xl px-6 pt-12 lg:px-8">

        <div class="grid overflow-hidden rounded-[2rem] border border-[#EAD8CD] bg-white shadow-sm sm:grid-cols-3">

            <div class="border-b border-[#EAD8CD] p-8 text-center sm:border-b-0 sm:border-r">
                <p class="brand-font text-4xl font-extrabold text-[#C77D56]">
                    {{ $availableCount }}
                </p>

                <p class="mt-2 text-sm font-medium text-[#88766D]">
                    Available food listings
                </p>
            </div>

            <div class="border-b border-[#EAD8CD] p-8 text-center sm:border-b-0 sm:border-r">
                <p class="brand-font text-4xl font-extrabold text-[#C77D56]">
                    {{ $organizationCount }}
                </p>

                <p class="mt-2 text-sm font-medium text-[#88766D]">
                    Participating organizations
                </p>
            </div>

            <div class="p-8 text-center">
                <p class="brand-font text-4xl font-extrabold text-[#C77D56]">
                    {{ $collectedCount }}
                </p>

                <p class="mt-2 text-sm font-medium text-[#88766D]">
                    Completed pickups
                </p>
            </div>

        </div>

    </section>


    <section id="how-it-works" class="mx-auto max-w-7xl px-6 py-28 lg:px-8">

        <div class="mx-auto max-w-2xl text-center">

            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                Simple process
            </p>

            <h2 class="brand-font mt-4 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                Good things happen in three steps.
            </h2>

            <p class="mt-5 leading-7 text-[#88766D]">
                FoodLoop makes it easy for food businesses and community
                organizations to work together.
            </p>

        </div>

        <div class="mt-14 grid gap-5 md:grid-cols-3">

            <article class="rounded-[2rem] border border-[#EAD8CD] bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                <p class="brand-font text-5xl font-extrabold text-[#E9A17D]">
                    01
                </p>

                <p class="mt-7 text-xs font-extrabold uppercase tracking-widest text-[#B96F4D]">
                    For food businesses
                </p>

                <h3 class="brand-font mt-3 text-xl font-extrabold text-[#4A342B]">
                    Donors publish
                </h3>

                <p class="mt-3 text-sm leading-7 text-[#88766D]">
                    Restaurants, cafés and supermarkets list their safe surplus
                    food with quantities and collection times.
                </p>

            </article>


            <article class="rounded-[2rem] border border-[#E9A17D]/40 bg-[#F7E8DE] p-8 transition hover:-translate-y-1 hover:shadow-lg">

                <p class="brand-font text-5xl font-extrabold text-[#B96F4D]">
                    02
                </p>

                <p class="mt-7 text-xs font-extrabold uppercase tracking-widest text-[#A66A4D]">
                    For community organizations
                </p>

                <h3 class="brand-font mt-3 text-xl font-extrabold text-[#4A342B]">
                    Charities reserve
                </h3>

                <p class="mt-3 text-sm leading-7 text-[#806B60]">
                    Recipient organizations browse available food and reserve
                    the quantities they need.
                </p>

            </article>


            <article class="rounded-[2rem] border border-[#EAD8CD] bg-[#F3EDE7] p-8 transition hover:-translate-y-1 hover:shadow-lg">

                <p class="brand-font text-5xl font-extrabold text-[#C77D56]">
                    03
                </p>

                <p class="mt-7 text-xs font-extrabold uppercase tracking-widest text-[#B96F4D]">
                    The final step
                </p>

                <h3 class="brand-font mt-3 text-xl font-extrabold text-[#4A342B]">
                    Food gets collected
                </h3>

                <p class="mt-3 text-sm leading-7 text-[#88766D]">
                    Organizations collect their reserved food and donors confirm
                    the completed pickup.
                </p>

            </article>

        </div>

    </section>


    <section id="food-listings" class="bg-white py-24">

        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                        From our community
                    </p>

                    <h2 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B]">
                        Fresh opportunities.
                    </h2>

                    <p class="mt-3 text-sm text-[#88766D]">
                        Discover the latest surplus food shared by local organizations.
                    </p>
                </div>

                <span class="w-fit rounded-full bg-[#F7E8DE] px-4 py-2 text-xs font-bold text-[#8E583D]">
                    {{ $availableCount }} listings available
                </span>

            </div>


            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($latestListings as $listing)
                    <x-listing-card :listing="$listing" />
                @empty

                    <div class="col-span-full rounded-3xl bg-[#FFF8F2] px-6 py-16 text-center">

                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                            Check back soon
                        </p>

                        <h3 class="brand-font mt-5 text-xl font-extrabold text-[#4A342B]">
                            No food listings available yet.
                        </h3>

                        <p class="mt-2 text-sm text-[#88766D]">
                            There are no food listings available right now.
                            Please check back soon.
                        </p>

                    </div>

                @endforelse

            </div>
            <div class="mt-10 text-center">
                <a href="{{ route('food-listings.index') }}"
                class="inline-flex rounded-full border border-[#EAD8CD] bg-white px-8 py-4 text-sm font-bold text-[#4A342B] transition hover:border-[#E9A17D] hover:bg-[#FFF3EB]">
                    See all available food
                </a>
            </div>

        </div>

    </section>


    <section class="mx-auto max-w-7xl px-6 py-24 lg:px-8">

        <div class="relative overflow-hidden rounded-[2.5rem] bg-[#4A342B] px-8 py-16 text-center sm:px-16">

            <div class="absolute -right-20 -top-24 h-64 w-64 rounded-full bg-[#E9A17D]/15"></div>
            <div class="absolute -bottom-32 -left-16 h-72 w-72 rounded-full bg-[#E9A17D]/10"></div>

            <div class="relative">

                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#E9A17D]">
                    Be part of the change
                </p>

                <h2 class="brand-font mx-auto mt-5 max-w-2xl text-4xl font-extrabold text-white sm:text-5xl">
                    Let's make every meal count.
                </h2>

                <p class="mx-auto mt-5 max-w-xl leading-7 text-white/65">
                    Whether you have surplus food or can put it to good use,
                    there's a place for you in the FoodLoop community.
                </p>

                @guest

                    <a href="{{ route('register') }}"
                       class="mt-9 inline-flex rounded-full bg-[#E9A17D] px-8 py-4 text-sm font-extrabold text-[#4A342B] transition hover:-translate-y-1 hover:bg-[#D98E69]">
                        Get started with FoodLoop
                    </a>

                @else

                    <a href="{{ route('dashboard') }}"
                       class="mt-9 inline-flex rounded-full bg-[#E9A17D] px-8 py-4 text-sm font-extrabold text-[#4A342B] transition hover:-translate-y-1 hover:bg-[#D98E69]">
                        Visit your dashboard
                    </a>

                @endguest

            </div>

        </div>

    </section>

</x-layouts.public>
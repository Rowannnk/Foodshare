<header class="sticky top-0 z-50 border-b border-[#EAD8CD] bg-[#FFF8F2]/95 backdrop-blur-xl">

    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

        <a href="{{ route('welcome') }}" class="flex items-center gap-3">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E9A17D] text-xl font-extrabold text-[#4A342B]">
                F
            </span>

            <span class="brand-font text-2xl font-extrabold tracking-tight text-[#4A342B]">
                FoodLoop
            </span>
        </a>

        <nav class="hidden items-center gap-9 text-sm font-semibold text-[#806F66] md:flex">

            <a href="{{ route('welcome') }}#home"
               class="transition hover:text-[#B96F4D]">
                Home
            </a>

            <a href="{{ route('welcome') }}#how-it-works"
               class="transition hover:text-[#B96F4D]">
                How it works
            </a>

            <a href="{{ route('food-listings.index') }}" ...>
                Available food
            </a>
            <a href="{{ route('categories.index') }}"
            class="transition hover:text-[#B96F4D]">
                Categories
            </a>

            @auth
            @if (auth()->user()->isRecipient())
                <a href="{{ route('reservations.index') }}"
                class="transition hover:text-[#B96F4D]">
                    My reservations
                </a>
            @endif
            @if (auth()->user()->isDonor() || auth()->user()->isAdmin())
                <a href="{{ route('my-listings.index') }}"
                class="transition hover:text-[#B96F4D]">
                    My listings
                </a>
            @endif
                <a href="{{ route('dashboard') }}"
                   class="transition hover:text-[#B96F4D]">
                    Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="transition hover:text-[#B96F4D]">
                        Log out
                    </button>
                </form>

            @else

                <a href="{{ route('login') }}"
                   class="transition hover:text-[#B96F4D]">
                    Log in
                </a>

                <a href="{{ route('register') }}"
                   class="rounded-full bg-[#E9A17D] px-6 py-3 font-bold text-[#4A342B] shadow-sm transition hover:-translate-y-0.5 hover:bg-[#D98E69]">
                    Get started
                </a>

            @endauth

        </nav>

        <details class="relative md:hidden">

            <summary class="cursor-pointer list-none rounded-full border border-[#EAD8CD] bg-white px-5 py-2.5 text-sm font-bold text-[#4A342B]">
                Menu
            </summary>

            <nav class="absolute right-0 top-14 w-64 rounded-2xl border border-[#EAD8CD] bg-white p-4 shadow-xl">

                <a href="{{ route('welcome') }}#home"
                   class="block rounded-xl px-4 py-3 text-sm font-semibold transition hover:bg-[#FFF3EB]">
                    Home
                </a>

                <a href="{{ route('welcome') }}#how-it-works"
                   class="block rounded-xl px-4 py-3 text-sm font-semibold transition hover:bg-[#FFF3EB]">
                    How it works
                </a>

                <a href="{{ route('food-listings.index') }}" ...>
                    Available food
                </a>
                <a href="{{ route('categories.index') }}"
                class="transition hover:text-[#B96F4D]">
                    Categories
                </a>

                @auth
                @if (auth()->user()->isRecipient())
                    <a href="{{ route('reservations.index') }}"
                    class="transition hover:text-[#B96F4D]">
                        My reservations
                    </a>
                @endif
                @if (auth()->user()->isDonor() || auth()->user()->isAdmin())
                    <a href="{{ route('my-listings.index') }}"
                    class="transition hover:text-[#B96F4D]">
                        My listings
                    </a>
                @endif
                    <a href="{{ route('dashboard') }}"
                       class="block rounded-xl px-4 py-3 text-sm font-semibold transition hover:bg-[#FFF3EB]">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="block w-full rounded-xl px-4 py-3 text-left text-sm font-semibold transition hover:bg-[#FFF3EB]">
                            Log out
                        </button>
                    </form>

                @else

                    <a href="{{ route('login') }}"
                       class="block rounded-xl px-4 py-3 text-sm font-semibold transition hover:bg-[#FFF3EB]">
                        Log in
                    </a>

                    <a href="{{ route('register') }}"
                       class="mt-2 block rounded-full bg-[#E9A17D] px-4 py-3 text-center text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                        Get started
                    </a>

                @endauth

            </nav>

        </details>

    </div>

</header>
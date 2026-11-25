@php
    $linkBase = 'rounded-full px-4 py-2 text-sm font-semibold transition';
    $linkIdle = 'text-[#806F66] hover:bg-[#F7E8DE] hover:text-[#4A342B]';
    $linkActive = 'bg-[#F7E8DE] text-[#4A342B]';
    $itemClass = 'block rounded-xl px-4 py-2.5 text-sm font-semibold text-[#4A342B] transition hover:bg-[#FFF3EB]';
@endphp

<header x-data="{ menu: false, user: false }"
        class="sticky top-0 z-50 border-b border-[#EAD8CD] bg-[#FFF8F2]/90 backdrop-blur-xl">

    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

        {{-- Logo --}}
        <a href="{{ route('welcome') }}" class="flex items-center gap-3">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E9A17D] text-xl font-extrabold text-[#4A342B]">
                F
            </span>
            <span class="brand-font text-2xl font-extrabold tracking-tight text-[#4A342B]">
                FoodLoop
            </span>
        </a>

        {{-- Main links (big screens) --}}
        <nav class="hidden items-center gap-1 md:flex">
            <a href="{{ route('welcome') }}"
            class="{{ $linkBase }} {{ request()->routeIs('welcome') ? $linkActive : $linkIdle }}">
                Home
            </a>

            <a href="{{ route('food-listings.index') }}"
               class="{{ $linkBase }} {{ request()->routeIs('food-listings.*') ? $linkActive : $linkIdle }}">
                Available food
            </a>

            <a href="{{ route('categories.index') }}"
               class="{{ $linkBase }} {{ request()->routeIs('categories.*') ? $linkActive : $linkIdle }}">
                Categories
            </a>

            @guest
                <a href="{{ route('welcome') }}#how-it-works" class="{{ $linkBase }} {{ $linkIdle }}">
                    How it works
                </a>
            @endguest
        </nav>

        {{-- Right side (big screens) --}}
        <div class="hidden items-center gap-3 md:flex">
            @auth
                <div class="relative" @click.outside="user = false">
                    <button type="button" @click="user = ! user"
                            class="flex items-center gap-3 rounded-full border border-[#EAD8CD] bg-white py-1.5 pl-1.5 pr-4 transition hover:border-[#E9A17D]">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#E9A17D] text-sm font-extrabold text-[#4A342B]">
                            {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <span class="text-sm font-bold text-[#4A342B]">
                            {{ \Illuminate\Support\Str::limit(auth()->user()->name, 16) }}
                        </span>
                        <svg class="h-4 w-4 text-[#806F66]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="user" x-transition style="display: none;"
                         class="absolute right-0 mt-3 w-64 rounded-2xl border border-[#EAD8CD] bg-white p-2 shadow-xl">

                        <div class="px-4 py-3">
                            <p class="text-sm font-bold text-[#4A342B]">{{ auth()->user()->name }}</p>
                            <p class="text-xs capitalize text-[#A18F84]">{{ auth()->user()->role->value }}</p>
                        </div>

                        <div class="border-t border-[#EAD8CD] pt-2">
                            <a href="{{ route('dashboard') }}" class="{{ $itemClass }}">Dashboard</a>

                            @if (auth()->user()->isRecipient())
                                <a href="{{ route('reservations.index') }}" class="{{ $itemClass }}">My reservations</a>
                            @endif

                            @if (auth()->user()->isDonor() || auth()->user()->isAdmin())
                                <a href="{{ route('my-listings.index') }}" class="{{ $itemClass }}">My listings</a>
                            @endif

                            <a href="{{ route('organizations.index') }}" class="{{ $itemClass }}">Organizations</a>
                            <a href="{{ route('pickups.index') }}" class="{{ $itemClass }}">Pickups</a>

                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="{{ $itemClass }}">Admin</a>
                            @endif
                        </div>

                        <div class="mt-2 border-t border-[#EAD8CD] pt-2">
                            <a href="{{ route('profile.edit') }}" class="{{ $itemClass }}">Profile</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="{{ $itemClass }} w-full text-left text-red-600">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="{{ $linkBase }} {{ $linkIdle }}">Log in</a>

                <a href="{{ route('register') }}"
                   class="rounded-full bg-[#E9A17D] px-6 py-2.5 text-sm font-bold text-[#4A342B] shadow-sm transition hover:-translate-y-0.5 hover:bg-[#D98E69]">
                    Get started
                </a>
            @endauth
        </div>

        {{-- Menu button (small screens) --}}
        <button type="button" @click="menu = ! menu"
                class="rounded-full border border-[#EAD8CD] bg-white p-3 text-[#4A342B] md:hidden"
                aria-label="Open menu">
            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path x-show="! menu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path x-show="menu" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Phone menu --}}
    <div x-show="menu" x-transition style="display: none;"
         class="border-t border-[#EAD8CD] bg-white md:hidden">
        <div class="space-y-1 px-4 py-4">
            <a href="{{ route('welcome') }}" class="{{ $itemClass }}">Home</a>
            <a href="{{ route('food-listings.index') }}" class="{{ $itemClass }}">Available food</a>
            <a href="{{ route('categories.index') }}" class="{{ $itemClass }}">Categories</a>

            @guest
                <a href="{{ route('welcome') }}#how-it-works" class="{{ $itemClass }}">How it works</a>
                <a href="{{ route('login') }}" class="{{ $itemClass }}">Log in</a>
                <a href="{{ route('register') }}"
                   class="mt-2 block rounded-full bg-[#E9A17D] px-4 py-3 text-center text-sm font-bold text-[#4A342B]">
                    Get started
                </a>
            @else
                <div class="my-3 border-t border-[#EAD8CD] px-4 pt-4">
                    <p class="text-sm font-bold text-[#4A342B]">{{ auth()->user()->name }}</p>
                    <p class="text-xs capitalize text-[#A18F84]">{{ auth()->user()->role->value }}</p>
                </div>

                <a href="{{ route('dashboard') }}" class="{{ $itemClass }}">Dashboard</a>

                @if (auth()->user()->isRecipient())
                    <a href="{{ route('reservations.index') }}" class="{{ $itemClass }}">My reservations</a>
                @endif

                @if (auth()->user()->isDonor() || auth()->user()->isAdmin())
                    <a href="{{ route('my-listings.index') }}" class="{{ $itemClass }}">My listings</a>
                @endif

                <a href="{{ route('organizations.index') }}" class="{{ $itemClass }}">Organizations</a>
                <a href="{{ route('pickups.index') }}" class="{{ $itemClass }}">Pickups</a>

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="{{ $itemClass }}">Admin</a>
                @endif

                <a href="{{ route('profile.edit') }}" class="{{ $itemClass }}">Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="{{ $itemClass }} w-full text-left text-red-600">Log out</button>
                </form>
            @endguest
        </div>
    </div>
</header>
<x-guest-layout>
    <div class="mb-8">
        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
            Welcome back
        </p>
        <h1 class="brand-font mt-3 text-3xl font-extrabold text-[#4A342B]">
            Login to FoodLoop
        </h1>
        <p class="mt-2 text-sm text-[#88766D]">
            Sign in to continue sharing good food.
        </p>
    </div>

    <x-breeze.auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <x-breeze.input-label for="email" value="Email address" class="!text-[#4A342B]" />
            <x-breeze.text-input
                id="email"
                class="mt-2 block w-full rounded-xl border-[#EAD8CD] focus:border-[#B96F4D] focus:ring-[#B96F4D]"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />
            <x-breeze.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <x-breeze.input-label for="password" value="Password" class="!text-[#4A342B]" />
            <x-breeze.text-input
                id="password"
                class="mt-2 block w-full rounded-xl border-[#EAD8CD] focus:border-[#B96F4D] focus:ring-[#B96F4D]"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <x-breeze.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember me and Forgot password --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-[#D8C5B9] text-[#B96F4D] shadow-sm focus:ring-[#B96F4D]"
                >
                <span class="text-sm text-[#88766D]">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm font-semibold text-[#B96F4D] transition hover:text-[#8E583D] hover:underline">
                    Forgot password?
                </a>
            @endif
        </div>

        {{-- Login button --}}
        <button type="submit"
                class="w-full rounded-full bg-[#E9A17D] px-6 py-3.5 text-sm font-extrabold text-[#4A342B] transition hover:bg-[#D98E69] focus:outline-none focus:ring-2 focus:ring-[#B96F4D] focus:ring-offset-2">
            Login
        </button>

        <p class="pt-2 text-center text-sm text-[#88766D]">
            Don't have an account?
            <a href="{{ route('register') }}"
               class="font-bold text-[#B96F4D] hover:underline">
                Register
            </a>
        </p>
    </form>
</x-guest-layout>

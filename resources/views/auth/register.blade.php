
<x-guest-layout>
    <div class="mb-8">
        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
            Join our community
        </p>
        <h1 class="brand-font mt-3 text-3xl font-extrabold text-[#4A342B]">
            Create an account
        </h1>
        <p class="mt-2 text-sm text-[#88766D]">
            Join FoodLoop and help reduce food waste.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <x-breeze.input-label for="name" value="Full name" class="!text-[#4A342B]" />
            <x-breeze.text-input
                id="name"
                class="mt-2 block w-full rounded-xl border-[#EAD8CD] focus:border-[#B96F4D] focus:ring-[#B96F4D]"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />
            <x-breeze.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

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
                autocomplete="username"
            />
            <x-breeze.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Role --}}
        <div>
            <x-breeze.input-label value="I am a..." class="!text-[#4A342B]" />

            <div class="mt-2 grid gap-3 sm:grid-cols-2">
                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-[#EAD8CD] p-4 transition hover:border-[#B96F4D] has-[:checked]:border-[#B96F4D] has-[:checked]:bg-[#FFF8F2]">
                    <input
                        type="radio"
                        name="role"
                        value="donor"
                        class="mt-1 border-[#D8C5B9] text-[#B96F4D] focus:ring-[#B96F4D]"
                        required
                        @checked(old('role') === 'donor')
                    >
                    <span>
                        <span class="block text-sm font-bold text-[#4A342B]">Food business</span>
                        <span class="mt-1 block text-xs leading-relaxed text-[#88766D]">
                            Restaurant, café, bakery or supermarket sharing surplus food.
                        </span>
                    </span>
                </label>

                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-[#EAD8CD] p-4 transition hover:border-[#B96F4D] has-[:checked]:border-[#B96F4D] has-[:checked]:bg-[#FFF8F2]">
                    <input
                        type="radio"
                        name="role"
                        value="recipient"
                        class="mt-1 border-[#D8C5B9] text-[#B96F4D] focus:ring-[#B96F4D]"
                        required
                        @checked(old('role') === 'recipient')
                    >
                    <span>
                        <span class="block text-sm font-bold text-[#4A342B]">Charity</span>
                        <span class="mt-1 block text-xs leading-relaxed text-[#88766D]">
                            Organization that reserves and collects available food.
                        </span>
                    </span>
                </label>
            </div>

            <x-breeze.input-error :messages="$errors->get('role')" class="mt-2" />
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
                autocomplete="new-password"
            />
            <x-breeze.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm password --}}
        <div>
            <x-breeze.input-label for="password_confirmation" value="Confirm password" class="!text-[#4A342B]" />
            <x-breeze.text-input
                id="password_confirmation"
                class="mt-2 block w-full rounded-xl border-[#EAD8CD] focus:border-[#B96F4D] focus:ring-[#B96F4D]"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />
            <x-breeze.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Register button --}}
        <button type="submit"
                class="w-full rounded-full bg-[#E9A17D] px-6 py-3.5 text-sm font-extrabold text-[#4A342B] transition hover:bg-[#D98E69] focus:outline-none focus:ring-2 focus:ring-[#B96F4D] focus:ring-offset-2">
            Create account
        </button>

        <p class="pt-2 text-center text-sm text-[#88766D]">
            Already have an account?
            <a href="{{ route('login') }}"
               class="font-bold text-[#B96F4D] hover:underline">
                Login
            </a>
        </p>
    </form>
</x-guest-layout>

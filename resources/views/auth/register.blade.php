<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-breeze.input-label for="name" value="Name" />
            <x-breeze.text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-breeze.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-breeze.input-label for="email" value="Email" />
            <x-breeze.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-breeze.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Role -->
        <div class="mt-4">
            <x-breeze.input-label value="I am a..." />

            <div class="mt-2 grid gap-3 sm:grid-cols-2">
                <label class="flex cursor-pointer items-start gap-3 rounded-md border border-gray-300 p-3 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="role" value="donor" class="mt-1" required
                           @checked(old('role') === 'donor')>
                    <span>
                        <span class="block text-sm font-semibold text-gray-800">Food business</span>
                        <span class="block text-xs text-gray-500">Restaurant, café, bakery or supermarket that shares surplus food (donor).</span>
                    </span>
                </label>

                <label class="flex cursor-pointer items-start gap-3 rounded-md border border-gray-300 p-3 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="role" value="recipient" class="mt-1" required
                           @checked(old('role') === 'recipient')>
                    <span>
                        <span class="block text-sm font-semibold text-gray-800">Charity</span>
                        <span class="block text-xs text-gray-500">Organization that reserves and collects food (recipient).</span>
                    </span>
                </label>
            </div>

            <x-breeze.input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-breeze.input-label for="password" value="Password" />

            <x-breeze.text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-breeze.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-breeze.input-label for="password_confirmation" value="Confirm Password" />

            <x-breeze.text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-breeze.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                Already registered?
            </a>

            <x-breeze.primary-button class="ms-4">
                Register
            </x-breeze.primary-button>
        </div>
    </form>
</x-guest-layout>

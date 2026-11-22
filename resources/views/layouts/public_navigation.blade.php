<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <a href="{{ route('welcome') }}" class="text-xl font-bold text-green-700">
            FoodLoop
        </a>

        <div class="flex items-center gap-6 text-sm font-medium text-gray-600">
            <a href="{{ route('welcome') }}" class="hover:text-green-700">Home</a>

            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-green-700">Dashboard</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:text-green-700">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-green-700">Log in</a>
                <a href="{{ route('register') }}"
                   class="bg-green-600 text-white px-3 py-2 rounded-md hover:bg-green-700">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>
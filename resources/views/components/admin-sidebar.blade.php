@php
    $links = [
        ['Dashboard', 'dashboard', 'dashboard', 'heroicon-o-squares-2x2'],
        ['Category Management', 'admin.categories.index', 'admin.categories.*', 'heroicon-o-tag'],
        ['Organization Management', 'organizations.index', 'organizations.*', 'heroicon-o-building-office-2'],
        ['Food Listing Management', 'my-listings.index', 'my-listings.*', 'heroicon-o-shopping-bag'],
        ['Pickup Management', 'pickups.index', 'pickups.*', 'heroicon-o-clock'],
    ];
@endphp

<aside class="border-b border-[#EAD8CD] bg-white lg:w-72 lg:shrink-0 lg:border-b-0 lg:border-r">
    <div class="flex flex-col p-3 lg:sticky lg:top-20 lg:h-[calc(100vh-5rem)] lg:overflow-y-auto lg:p-5">
        <div class="hidden items-center gap-3 px-3 pb-5 lg:flex">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#4A342B] text-[#E9A17D]">
                <x-heroicon-o-shield-check class="h-5 w-5" />
            </span>
            <div>
                <p class="text-sm font-extrabold text-[#4A342B]">Admin panel</p>
                <p class="text-xs text-[#A18F84]">Manage FoodLoop</p>
            </div>
        </div>

        <nav class="flex gap-2 overflow-x-auto lg:flex-col lg:overflow-visible">
            @foreach ($links as [$label, $routeName, $pattern, $icon])
                <a href="{{ route($routeName) }}"
                   class="flex items-center gap-3 whitespace-nowrap rounded-xl px-4 py-3 text-sm font-semibold transition lg:whitespace-normal
                          {{ request()->routeIs($pattern) ? 'bg-[#4A342B] text-white shadow-sm' : 'text-[#806F66] hover:bg-[#F7E8DE] hover:text-[#4A342B]' }}">
                    <x-dynamic-component :component="$icon" class="h-5 w-5 shrink-0" />
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="mt-auto hidden border-t border-[#EAD8CD] pt-4 lg:block">
            <a href="{{ route('welcome') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#806F66] transition hover:bg-[#F7E8DE] hover:text-[#4A342B]">
                <x-heroicon-o-arrow-left class="h-5 w-5 shrink-0" />
                Back to website
            </a>
        </div>
    </div>
</aside>
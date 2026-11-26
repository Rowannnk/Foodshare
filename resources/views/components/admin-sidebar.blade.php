@php
    $links = [
        ['Dashboard', 'dashboard', 'dashboard', 'heroicon-o-squares-2x2'],
        ['Categories', 'admin.categories.index', 'admin.categories.*', 'heroicon-o-tag'],
        ['Organizations', 'admin.organizations.index', 'admin.organizations.*', 'heroicon-o-building-office-2'],
        ['Food Listings', 'admin.food-listings.index', 'admin.food-listings.*', 'heroicon-o-shopping-bag'],
        ['Pickups', 'admin.pickups.index', 'admin.pickups.*', 'heroicon-o-clock'],
    ];
@endphp

<aside class="border-b border-[#EAD8CD] bg-white lg:w-64 lg:shrink-0 lg:border-b-0 lg:border-r">
    <div class="flex flex-col p-3 lg:sticky lg:top-16 lg:h-[calc(100vh-4rem)] lg:overflow-y-auto lg:p-5">

        <div class="mb-5 hidden px-3 pt-2 lg:block">
            <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[#A18F84]">
                Workspace
            </p>
        </div>

        <nav class="flex gap-2 overflow-x-auto lg:flex-col lg:overflow-visible">

            @foreach ($links as [$label, $routeName, $pattern, $icon])
                @php
                    $active = request()->routeIs($pattern);
                @endphp

                <a href="{{ route($routeName) }}"
                   @class([
                       'group flex items-center gap-3 whitespace-nowrap rounded-xl px-4 py-3 text-sm font-semibold transition lg:whitespace-normal',
                       'bg-[#4A342B] text-white shadow-sm' => $active,
                       'text-[#806F66] hover:bg-[#F7E8DE] hover:text-[#4A342B]' => ! $active,
                   ])>

                    <x-dynamic-component
                        :component="$icon"
                        @class([
                            'h-5 w-5 shrink-0 transition',
                            'text-[#E9A17D]' => $active,
                            'text-[#A18F84] group-hover:text-[#8E583D]' => ! $active,
                        ])
                    />

                    {{ $label }}

                    @if ($active)
                        <span class="ml-auto hidden h-1.5 w-1.5 rounded-full bg-[#E9A17D] lg:block"></span>
                    @endif
                </a>
            @endforeach

        </nav>

        <div class="mt-auto hidden border-t border-[#EAD8CD] pt-5 lg:block">
            <a href="{{ route('welcome') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#806F66] transition hover:bg-[#F7E8DE] hover:text-[#4A342B]">
                <x-heroicon-o-arrow-left class="h-5 w-5 shrink-0" />
                Back to website
            </a>

            <div class="mt-5 rounded-2xl bg-[#FFF8F2] p-4">
                <p class="text-xs font-bold text-[#4A342B]">FoodLoop Admin</p>
                <p class="mt-1 text-xs leading-5 text-[#88766D]">
                    Manage food sharing activities and keep the community connected.
                </p>
            </div>
        </div>

    </div>
</aside>

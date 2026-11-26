@props([
    'action',
    'filters' => [],
    'placeholder' => 'Search...',
])

<div class="rounded-2xl border border-[#EAD8CD] bg-white p-5">

    <form method="GET" action="{{ $action }}"
          class="flex flex-col gap-4 lg:flex-row lg:items-end">
        <div class="min-w-0 flex-1">
            <label for="admin-search"
                   class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#88766D]">
                Search
            </label>

            <div class="relative">
                <x-heroicon-o-magnifying-glass
                    class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#A18F84]" />

                <input
                    type="text"
                    name="search"
                    id="admin-search"
                    value="{{ request('search') }}"
                    placeholder="{{ $placeholder }}"
                    class="w-full rounded-xl border border-[#EAD8CD] bg-[#FFFCF9] py-3 pl-11 pr-4 text-sm text-[#4A342B] outline-none transition placeholder:text-[#B5A69D] focus:border-[#B96F4D] focus:ring-2 focus:ring-[#E9A17D]/20"
                >
            </div>
        </div>
        @foreach ($filters as $filter)
            <div class="w-full lg:w-56">
                <label for="filter-{{ $filter['name'] }}"
                       class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#88766D]">
                    {{ $filter['label'] }}
                </label>

                <select
                    name="{{ $filter['name'] }}"
                    id="filter-{{ $filter['name'] }}"
                    class="w-full rounded-xl border border-[#EAD8CD] bg-[#FFFCF9] px-4 py-3 text-sm text-[#4A342B] outline-none transition focus:border-[#B96F4D] focus:ring-2 focus:ring-[#E9A17D]/20"
                >
                    <option value="">
                        {{ $filter['placeholder'] ?? 'All' }}
                    </option>

                    @foreach ($filter['options'] as $value => $label)
                        <option value="{{ $value }}"
                                @selected(request($filter['name']) == $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endforeach
        <div class="flex gap-2">
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#4A342B] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#62483C]">
                <x-heroicon-o-funnel class="h-4 w-4" />
                Apply
            </button>

            <a href="{{ $action }}"
               class="inline-flex items-center justify-center rounded-xl border border-[#EAD8CD] px-5 py-3 text-sm font-bold text-[#806F66] transition hover:bg-[#FFF8F2]">
                Clear
            </a>
        </div>

    </form>
    @if (request()->filled('search') || collect($filters)->contains(fn ($filter) => request()->filled($filter['name'])))
        <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-[#F0E4DC] pt-4">
            <span class="text-xs font-semibold text-[#88766D]">
                Active filters:
            </span>

            @if (request()->filled('search'))
                <span class="rounded-full bg-[#FFF1E8] px-3 py-1 text-xs font-semibold text-[#9A6248]">
                    Search: {{ request('search') }}
                </span>
            @endif

            @foreach ($filters as $filter)
                @if (request()->filled($filter['name']))
                    <span class="rounded-full bg-[#FFF1E8] px-3 py-1 text-xs font-semibold text-[#9A6248]">
                        {{ $filter['label'] }}:
                        {{ $filter['options'][request($filter['name'])] ?? request($filter['name']) }}
                    </span>
                @endif
            @endforeach
        </div>
    @endif

</div>

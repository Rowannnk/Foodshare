<x-layouts.admin title="Users - Admin - FoodLoop">

    <div class="mx-auto max-w-7xl space-y-8 px-6 py-10 lg:px-8">

        {{-- Page Heading --}}
        <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">

            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                    User Management
                </p>

                <h1 class="brand-font mt-2 text-3xl font-extrabold tracking-tight text-[#4A342B] sm:text-4xl">
                    Users
                </h1>

                <p class="mt-2 text-sm text-[#88766D]">
                    View registered users and their organizations across FoodLoop.
                </p>
            </div>

        </section>

        {{-- Statistics --}}
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">
                            Total Users
                        </p>

                        <p class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                            {{ $users->total() }}
                        </p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#F7E8DE] text-[#B96F4D]">
                        <x-heroicon-o-users class="h-6 w-6" />
                    </span>

                </div>

                <p class="mt-3 text-xs text-[#A18F84]">
                    All registered platform users
                </p>
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">
                            Users on This Page
                        </p>

                        <p class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                            {{ $users->count() }}
                        </p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-700">
                        <x-heroicon-o-user-group class="h-6 w-6" />
                    </span>

                </div>

                <p class="mt-3 text-xs text-[#A18F84]">
                    Users displayed on the current page
                </p>
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">
                            Organizations
                        </p>

                        <p class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                            {{ $users->getCollection()->sum('organizations_count') }}
                        </p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#F7E8DE] text-[#B96F4D]">
                        <x-heroicon-o-building-office-2 class="h-6 w-6" />
                    </span>

                </div>

                <p class="mt-3 text-xs text-[#A18F84]">
                    Organizations belonging to users on this page
                </p>
            </div>

        </section>

        {{-- Search --}}
        <form action="{{ route('admin.users.index') }}" method="GET"
              class="flex flex-col gap-3 sm:flex-row">

            <div class="relative flex-1">

                <x-heroicon-o-magnifying-glass
                    class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#A18F84]"
                />

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search user name or email..."
                    class="w-full rounded-xl border border-[#EAD8CD] bg-white py-3 pl-12 pr-4 text-sm text-[#4A342B] outline-none transition placeholder:text-[#A18F84] focus:border-[#B96F4D] focus:ring-2 focus:ring-[#F7E8DE]"
                >

            </div>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#4A342B] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#765748]">

                <x-heroicon-o-magnifying-glass class="h-4 w-4" />

                Search
            </button>

            @if (request()->filled('search'))
                <a href="{{ route('admin.users.index') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-[#EAD8CD] bg-white px-5 py-3 text-sm font-bold text-[#806F66] transition hover:bg-[#FFF8F2]">

                    Clear
                </a>
            @endif

        </form>

        {{-- Users Table --}}
        <section class="overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white shadow-sm">

            <div class="flex flex-col justify-between gap-2 border-b border-[#EAD8CD] px-6 py-5 sm:flex-row sm:items-center">

                <div>
                    <h2 class="font-bold text-[#4A342B]">
                        All Users
                    </h2>

                    <p class="mt-1 text-xs text-[#A18F84]">
                        View registered FoodLoop users and their organization information.
                    </p>
                </div>

                <span class="w-fit rounded-lg bg-[#FFF8F2] px-3 py-2 text-xs font-bold text-[#806F66]">

                    {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}
                    of {{ $users->total() }} users

                </span>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[650px] text-left text-sm">

                    <thead class="bg-[#FFF8F2] text-[11px] font-extrabold uppercase tracking-wider text-[#A18F84]">

                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Email Address</th>
                            <th class="px-6 py-4">Organizations</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-[#F1E6DE]">

                        @forelse ($users as $user)

                            <tr class="transition hover:bg-[#FFFCF9]">

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#F7E8DE] text-sm font-extrabold text-[#8E583D]">

                                            {{ strtoupper(substr($user->name, 0, 1)) }}

                                        </span>

                                        <span class="font-bold text-[#4A342B]">
                                            {{ $user->name }}
                                        </span>

                                    </div>

                                </td>

                                <td class="px-6 py-5 text-[#88766D]">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-5">

                                    <span class="inline-flex items-center gap-2 font-semibold text-[#4A342B]">

                                        <x-heroicon-o-building-office-2 class="h-4 w-4 text-[#B96F4D]" />

                                        {{ $user->organizations_count }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="3" class="px-6 py-16 text-center">

                                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#B96F4D]">

                                        <x-heroicon-o-users class="h-7 w-7" />

                                    </span>

                                    <h3 class="mt-4 font-bold text-[#4A342B]">
                                        No users found
                                    </h3>

                                    <p class="mt-1 text-sm text-[#88766D]">
                                        No registered users match your search.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if ($users->hasPages())

                <div class="border-t border-[#EAD8CD] px-6 py-5">
                    {{ $users->links() }}
                </div>

            @endif

        </section>

    </div>

</x-layouts.admin>
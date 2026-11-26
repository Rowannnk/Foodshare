
<x-layouts.public title="Organizations - FoodLoop">
    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-6 px-6 py-12 sm:flex-row sm:items-end lg:px-8">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                    {{ auth()->user()->isAdmin() ? 'All organizations' : 'Owned by you' }}
                </p>

                <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                    Organizations
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-6 text-[#88766D]">
                    {{ auth()->user()->isAdmin()
                        ? 'View and manage organizations registered on FoodLoop.'
                        : 'Manage your organization and keep track of its food listings.' }}
                </p>
            </div>

            <a href="{{ route('organizations.create') }}"
               class="inline-flex w-fit items-center justify-center rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] transition hover:-translate-y-0.5 hover:bg-[#D98E69]">
                + New organization
            </a>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        @error('organization')
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                {{ $message }}
            </div>
        @enderror

        @if ($organizations->isEmpty())
            <div class="rounded-3xl border border-[#EAD8CD] bg-white px-6 py-16 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#8E583D]">
                    <x-heroicon-o-building-office-2 class="h-8 w-8" />
                </div>

                <h2 class="brand-font mt-5 text-2xl font-extrabold text-[#4A342B]">
                    No organizations yet
                </h2>

                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#88766D]">
                    Create your first organization to start sharing food with your community.
                </p>

                <a href="{{ route('organizations.create') }}"
                   class="mt-6 inline-flex rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                    Create organization
                </a>
            </div>

        @else
            <div class="mb-6 flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                <div>
                    <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">
                        Organization list
                    </h2>
                    <p class="mt-1 text-sm text-[#88766D]">
                        View organization details and manage your records.
                    </p>
                </div>

                <p class="text-sm text-[#88766D]">
                    {{ $organizations->total() }} organizations
                </p>
            </div>
            <div class="overflow-x-auto rounded-3xl border border-[#EAD8CD] bg-white">

                <table class="w-full min-w-[850px] text-left text-sm">

                    <thead class="border-b border-[#EAD8CD] bg-[#FFF8F2] text-[10px] font-extrabold uppercase tracking-[0.15em] text-[#A18F84]">
                        <tr>
                            <th class="px-6 py-5">Organization</th>
                            <th class="px-6 py-5">Type</th>
                            <th class="px-6 py-5">City</th>

                            @if (auth()->user()->isAdmin())
                                <th class="px-6 py-5">Owner</th>
                            @endif

                            <th class="px-6 py-5">Listings</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#F1E5DC]">

                        @foreach ($organizations as $organization)

                            <tr class="transition hover:bg-[#FFFCF9]">
                                <td class="px-6 py-5">
                                    <a href="{{ route('organizations.show', $organization) }}"
                                       class="font-bold text-[#4A342B] transition hover:text-[#B96F4D]">
                                        {{ $organization->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-5 capitalize text-[#88766D]">
                                    {{ $organization->type->value }}
                                </td>
                                <td class="px-6 py-5 text-[#88766D]">
                                    {{ $organization->city ?? '-' }}
                                </td>
                                @if (auth()->user()->isAdmin())
                                    <td class="px-6 py-5 text-[#88766D]">
                                        {{ $organization->user->name }}
                                    </td>
                                @endif
                                <td class="px-6 py-5">
                                    <span class="inline-flex rounded-full bg-[#FFF8F2] px-3 py-1 text-xs font-bold text-[#806F66]">
                                        {{ $organization->food_listings_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    @if ($organization->is_active)
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-[#C9DFC9] bg-[#E8F3E8] px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-[#47764B]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#47764B]"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-[#EAD8CD] bg-[#F7E8DE] px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-[#8E583D]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#8E583D]"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-end gap-4">

                                        <a href="{{ route('organizations.show', $organization) }}"
                                        class="font-semibold text-[#B96F4D] transition hover:text-[#8E583D] hover:underline">
                                            View
                                        </a>
                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
            @if ($organizations->hasPages())
                <div class="mt-10">
                    {{ $organizations->links() }}
                </div>
            @endif

        @endif

    </section>

</x-layouts.public>

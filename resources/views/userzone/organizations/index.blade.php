<x-layouts.public title="Organizations - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-6 px-6 py-14 sm:flex-row sm:items-end lg:px-8">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                    {{ auth()->user()->isAdmin() ? 'All organizations' : 'Owned by you' }}
                </p>
                <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                    Organizations
                </h1>
            </div>

            <a href="{{ route('organizations.create') }}"
               class="w-fit rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                + New organization
            </a>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        @error('organization')
            <p class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                {{ $message }}
            </p>
        @enderror

        @if ($organizations->isEmpty())
            <div class="rounded-3xl border border-[#EAD8CD] bg-white px-6 py-16 text-center">
                <h2 class="brand-font text-xl font-extrabold text-[#4A342B]">No organizations yet</h2>
                <p class="mt-2 text-sm text-[#88766D]">Create your first organization to get started.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-[1.5rem] border border-[#EAD8CD] bg-white">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-[#EAD8CD] bg-[#FFF8F2] text-xs uppercase tracking-widest text-[#A18F84]">
                        <tr>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">City</th>
                            @if (auth()->user()->isAdmin())
                                <th class="px-6 py-4">Owner</th>
                            @endif
                            <th class="px-6 py-4">Listings</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EAD8CD]">
                        @foreach ($organizations as $organization)
                            <tr>
                                <td class="px-6 py-4 font-semibold text-[#4A342B]">
                                    <a href="{{ route('organizations.show', $organization) }}" class="hover:underline">
                                        {{ $organization->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 capitalize text-[#88766D]">{{ $organization->type->value }}</td>
                                <td class="px-6 py-4 text-[#88766D]">{{ $organization->city ?? '-' }}</td>
                                @if (auth()->user()->isAdmin())
                                    <td class="px-6 py-4 text-[#88766D]">{{ $organization->user->name }}</td>
                                @endif
                                <td class="px-6 py-4">{{ $organization->food_listings_count }}</td>
                                <td class="px-6 py-4">
                                    @if ($organization->is_active)
                                        <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">Active</span>
                                    @else
                                        <span class="rounded-full bg-stone-100 px-3 py-1 text-xs font-bold text-stone-500">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('organizations.edit', $organization) }}"
                                           class="font-semibold text-[#B96F4D] hover:underline">Edit</a>

                                        <form method="POST" action="{{ route('organizations.destroy', $organization) }}"
                                              onsubmit="return confirm('Delete this organization?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-semibold text-red-600 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-10">
                {{ $organizations->links() }}
            </div>
        @endif
    </section>

</x-layouts.public>
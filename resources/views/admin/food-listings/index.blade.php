<x-layouts.admin title="Food Listings - Admin - FoodLoop">
    <div class="mx-auto max-w-7xl space-y-8 px-6 py-10 lg:px-8">
        <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                    Content Management
                </p>

                <h1 class="brand-font mt-2 text-3xl font-extrabold tracking-tight text-[#4A342B] sm:text-4xl">
                    Food Listings
                </h1>

                <p class="mt-2 text-sm text-[#88766D]">
                    Manage food listings from all organizations.
                </p>
            </div>

            <a href="{{ route('admin.food-listings.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#4A342B] px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#765748]">
                <x-heroicon-o-plus class="h-5 w-5" />
                New Listing
            </a>
        </section>
        @if (session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-700">
                {{ session('success') }}
            </div>
        @endif
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">Total Listings</p>
                        <p class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                            {{ $listings->total() }}
                        </p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#F7E8DE] text-[#B96F4D]">
                        <x-heroicon-o-shopping-bag class="h-6 w-6" />
                    </span>
                </div>

                <p class="mt-3 text-xs text-[#A18F84]">
                    All food listings on FoodLoop
                </p>
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">Listings on This Page</p>
                        <p class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                            {{ $listings->count() }}
                        </p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-700">
                        <x-heroicon-o-clipboard-document-list class="h-6 w-6" />
                    </span>
                </div>

                <p class="mt-3 text-xs text-[#A18F84]">
                    Listings on the current page
                </p>
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">Reservations on This Page</p>
                        <p class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                            {{ $listings->sum('reservations_count') }}
                        </p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-orange-700">
                        <x-heroicon-o-calendar-days class="h-6 w-6" />
                    </span>
                </div>

                <p class="mt-3 text-xs text-[#A18F84]">
                    Reservations across displayed listings
                </p>
            </div>

        </section>
        <x-admin.search-filter
            :action="route('admin.food-listings.index')"
            placeholder="Search by listing title or organization..."
            :filters="[]"
        />
        <section class="overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white shadow-sm">

            <div class="flex flex-col justify-between gap-2 border-b border-[#EAD8CD] px-6 py-5 sm:flex-row sm:items-center">
                <div>
                    <h2 class="font-bold text-[#4A342B]">All Food Listings</h2>
                    <p class="mt-1 text-xs text-[#A18F84]">
                        View and manage food listings from all organizations.
                    </p>
                </div>

                <span class="w-fit rounded-lg bg-[#FFF8F2] px-3 py-2 text-xs font-bold text-[#806F66]">
                    {{ $listings->firstItem() ?? 0 }}–{{ $listings->lastItem() ?? 0 }}
                    of {{ $listings->total() }} listings
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[950px] text-left text-sm">

                    <thead class="bg-[#FFF8F2] text-[11px] font-extrabold uppercase tracking-wider text-[#A18F84]">
                        <tr>
                            <th class="px-6 py-4">Food Listing</th>
                            <th class="px-6 py-4">Organization</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Quantity</th>
                            <th class="px-6 py-4">Reservations</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#F1E6DE]">

                        @forelse ($listings as $listing)
                            <tr class="transition hover:bg-[#FFFCF9]">

                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="h-12 w-12 shrink-0 overflow-hidden rounded-xl bg-[#FFF8F2]">
                                            <x-listing-thumb :listing="$listing" size="h-12 w-12" />
                                        </div>

                                        <div class="min-w-0">
                                            <a href="{{ route('admin.food-listings.show', $listing) }}"
                                               class="font-bold text-[#4A342B] transition hover:text-[#B96F4D]">
                                                {{ $listing->title }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="font-semibold text-[#4A342B]">
                                        {{ $listing->organization->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="rounded-lg bg-[#FFF8F2] px-3 py-1.5 text-xs font-semibold text-[#806F66]">
                                        {{ $listing->foodCategory->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="font-semibold text-[#4A342B]">
                                        {{ $listing->quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-2 font-semibold text-[#4A342B]">
                                        <x-heroicon-o-calendar-days class="h-4 w-4 text-[#B96F4D]" />
                                        {{ $listing->reservations_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex rounded-full bg-[#F7E8DE] px-3 py-1.5 text-xs font-bold capitalize text-[#8E583D]">
                                        {{ str_replace('_', ' ', $listing->status->value) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-end gap-2">

                                        <a href="{{ route('admin.food-listings.show', $listing) }}"
                                           title="View listing"
                                           class="rounded-lg p-2 text-[#806F66] transition hover:bg-[#F7E8DE] hover:text-[#4A342B]">
                                            <x-heroicon-o-eye class="h-4 w-4" />
                                        </a>

                                        <a href="{{ route('admin.food-listings.edit', $listing) }}"
                                           title="Edit listing"
                                           class="rounded-lg p-2 text-[#B96F4D] transition hover:bg-[#F7E8DE]">
                                            <x-heroicon-o-pencil-square class="h-4 w-4" />
                                        </a>

                                        <button type="button"
                                                title="Delete listing"
                                                data-delete-url="{{ route('admin.food-listings.destroy', $listing) }}"
                                                data-listing-name="{{ $listing->title }}"
                                                onclick="openListingDeleteDialog(this)"
                                                class="rounded-lg p-2 text-red-500 transition hover:bg-red-50 hover:text-red-700">
                                            <x-heroicon-o-trash class="h-4 w-4" />
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#B96F4D]">
                                        <x-heroicon-o-shopping-bag class="h-7 w-7" />
                                    </span>

                                    <h3 class="mt-4 font-bold text-[#4A342B]">
                                        No food listings found
                                    </h3>

                                    <p class="mt-1 text-sm text-[#88766D]">
                                        Create a food listing to get started.
                                    </p>

                                    <a href="{{ route('admin.food-listings.create') }}"
                                       class="mt-5 inline-flex rounded-xl bg-[#4A342B] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#765748]">
                                        Create Listing
                                    </a>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            @if ($listings->hasPages())
                <div class="border-t border-[#EAD8CD] px-6 py-5">
                    {{ $listings->links() }}
                </div>
            @endif

        </section>

    </div>
    <dialog id="listingDeleteDialog"
            class="m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl border border-[#EAD8CD] bg-white p-0 text-[#4A342B] shadow-2xl backdrop:bg-[#2B211D]/50">

        <div class="p-6 sm:p-7">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600">
                <x-heroicon-o-trash class="h-6 w-6" />
            </span>

            <h2 class="mt-5 text-xl font-extrabold">Delete food listing?</h2>

            <p class="mt-2 text-sm leading-6 text-[#88766D]">
                Are you sure you want to delete
                <strong id="listingDeleteName" class="text-[#4A342B]"></strong>?
                This action cannot be undone.
            </p>

            <div class="mt-7 flex justify-end gap-3">
                <button type="button"
                        onclick="closeListingDeleteDialog()"
                        class="rounded-xl border border-[#EAD8CD] px-5 py-2.5 text-sm font-bold text-[#806F66] transition hover:bg-[#FFF8F2]">
                    Cancel
                </button>

                <form id="listingDeleteForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-red-700">
                        Delete Listing
                    </button>
                </form>
            </div>
        </div>

    </dialog>

    <script>
        const listingDeleteDialog = document.getElementById('listingDeleteDialog');
        const listingDeleteForm = document.getElementById('listingDeleteForm');
        const listingDeleteName = document.getElementById('listingDeleteName');

        function openListingDeleteDialog(button) {
            listingDeleteForm.action = button.dataset.deleteUrl;
            listingDeleteName.textContent = button.dataset.listingName;
            listingDeleteDialog.showModal();
        }

        function closeListingDeleteDialog() {
            listingDeleteDialog.close();
        }

        listingDeleteDialog.addEventListener('click', function (event) {
            if (event.target === listingDeleteDialog) {
                listingDeleteDialog.close();
            }
        });
    </script>

</x-layouts.admin>

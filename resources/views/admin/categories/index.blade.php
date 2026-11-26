<x-layouts.admin title="Categories - Admin - FoodLoop">
    <div class="mx-auto max-w-7xl space-y-8 px-6 py-10 lg:px-8">
        <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                    Content Management
                </p>
                <h1 class="brand-font mt-2 text-3xl font-extrabold tracking-tight text-[#4A342B] sm:text-4xl">
                    Food Categories
                </h1>
                <p class="mt-2 text-sm text-[#88766D]">
                    Organize and manage the food categories available on FoodLoop.
                </p>
            </div>
            <a href="{{ route('admin.categories.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#4A342B] px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#765748]">
                <x-heroicon-o-plus class="h-5 w-5" />
                New Category
            </a>
        </section>
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">Total Categories</p>
                        <p class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                            {{ $categories->total() }}
                        </p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#F7E8DE] text-[#B96F4D]">
                        <x-heroicon-o-tag class="h-6 w-6" />
                    </span>
                </div>
                <p class="mt-3 text-xs text-[#A18F84]">All registered food categories</p>
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">Active on This Page</p>
                        <p class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                            {{ $categories->where('is_active', true)->count() }}
                        </p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-700">
                        <x-heroicon-o-check-circle class="h-6 w-6" />
                    </span>
                </div>
                <p class="mt-3 text-xs text-[#A18F84]">Active categories on the current page</p>
            </div>

            <div class="rounded-2xl border border-[#EAD8CD] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-[#88766D]">Inactive on This Page</p>
                        <p class="mt-3 text-3xl font-extrabold text-[#4A342B] tabular-nums">
                            {{ $categories->where('is_active', false)->count() }}
                        </p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-stone-100 text-stone-500">
                        <x-heroicon-o-pause-circle class="h-6 w-6" />
                    </span>
                </div>
                <p class="mt-3 text-xs text-[#A18F84]">Inactive categories on the current page</p>
            </div>
        </section>
        <x-admin.search-filter
            :action="route('admin.categories.index')"
            placeholder="Search categories by name or slug..."
            :filters="[
                [
                    'name' => 'status',
                    'label' => 'Status',
                    'placeholder' => 'All statuses',
                    'options' => [
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ],
                ],
            ]"
        />
        <section class="overflow-hidden rounded-2xl border border-[#EAD8CD] bg-white shadow-sm">

            <div class="flex flex-col justify-between gap-2 border-b border-[#EAD8CD] px-6 py-5 sm:flex-row sm:items-center">
                <div>
                    <h2 class="font-bold text-[#4A342B]">All Categories</h2>
                    <p class="mt-1 text-xs text-[#A18F84]">
                        View and manage your food categories.
                    </p>
                </div>

                <span class="w-fit rounded-lg bg-[#FFF8F2] px-3 py-2 text-xs font-bold text-[#806F66]">
                    {{ $categories->firstItem() ?? 0 }}–{{ $categories->lastItem() ?? 0 }}
                    of {{ $categories->total() }} categories
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left text-sm">

                    <thead class="bg-[#FFF8F2] text-[11px] font-extrabold uppercase tracking-wider text-[#A18F84]">
                        <tr>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4">Food Listings</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#F1E6DE]">

                        @forelse ($categories as $category)
                            <tr class="transition hover:bg-[#FFFCF9]">

                                <td class="px-6 py-5">
                                    <a href="{{ route('admin.categories.show', $category) }}"
                                       class="font-bold text-[#4A342B] transition hover:text-[#B96F4D]">
                                        {{ $category->name }}
                                    </a>
                                </td>

                                <td class="px-6 py-5">
                                    <code class="rounded-lg bg-[#FFF8F2] px-2.5 py-1.5 text-xs text-[#806F66]">
                                        {{ $category->slug }}
                                    </code>
                                </td>

                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-2 font-semibold text-[#4A342B]">
                                        <x-heroicon-o-rectangle-stack class="h-4 w-4 text-[#B96F4D]" />
                                        {{ $category->food_listings_count }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    @if ($category->is_active)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-3 py-1.5 text-xs font-bold text-green-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-stone-100 px-3 py-1.5 text-xs font-bold text-stone-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-stone-400"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-end gap-2">

                                        <a href="{{ route('admin.categories.show', $category) }}"
                                           title="View category"
                                           class="rounded-lg p-2 text-[#806F66] transition hover:bg-[#F7E8DE] hover:text-[#4A342B]">
                                            <x-heroicon-o-eye class="h-4 w-4" />
                                        </a>

                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                           title="Edit category"
                                           class="rounded-lg p-2 text-[#B96F4D] transition hover:bg-[#F7E8DE]">
                                            <x-heroicon-o-pencil-square class="h-4 w-4" />
                                        </a>

                                        <button type="button"
                                                title="Delete category"
                                                data-delete-url="{{ route('admin.categories.destroy', $category) }}"
                                                data-category-name="{{ $category->name }}"
                                                onclick="openCategoryDeleteDialog(this)"
                                                class="rounded-lg p-2 text-red-500 transition hover:bg-red-50 hover:text-red-700">
                                            <x-heroicon-o-trash class="h-4 w-4" />
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F7E8DE] text-[#B96F4D]">
                                        <x-heroicon-o-tag class="h-7 w-7" />
                                    </span>

                                    <h3 class="mt-4 font-bold text-[#4A342B]">
                                        No categories found
                                    </h3>

                                    <p class="mt-1 text-sm text-[#88766D]">
                                        Create your first food category to get started.
                                    </p>

                                    <a href="{{ route('admin.categories.create') }}"
                                       class="mt-5 inline-flex rounded-xl bg-[#4A342B] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#765748]">
                                        Create Category
                                    </a>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="border-t border-[#EAD8CD] px-6 py-5">
                    {{ $categories->links() }}
                </div>
            @endif

        </section>

    </div>
    <dialog id="categoryDeleteDialog"
            class="m-auto w-[calc(100%-2rem)] max-w-md rounded-2xl border border-[#EAD8CD] bg-white p-0 text-[#4A342B] shadow-2xl backdrop:bg-[#2B211D]/50">

        <div class="p-6 sm:p-7">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600">
                <x-heroicon-o-trash class="h-6 w-6" />
            </span>

            <h2 class="mt-5 text-xl font-extrabold">Delete category?</h2>

            <p class="mt-2 text-sm leading-6 text-[#88766D]">
                Are you sure you want to delete
                <strong id="categoryDeleteName" class="text-[#4A342B]"></strong>?
                This action cannot be undone.
            </p>

            <div class="mt-7 flex justify-end gap-3">
                <button type="button"
                        onclick="closeCategoryDeleteDialog()"
                        class="rounded-xl border border-[#EAD8CD] px-5 py-2.5 text-sm font-bold text-[#806F66] transition hover:bg-[#FFF8F2]">
                    Cancel
                </button>

                <form id="categoryDeleteForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-red-700">
                        Delete Category
                    </button>
                </form>
            </div>
        </div>

    </dialog>

    <script>
        const categoryDeleteDialog = document.getElementById('categoryDeleteDialog');
        const categoryDeleteForm = document.getElementById('categoryDeleteForm');
        const categoryDeleteName = document.getElementById('categoryDeleteName');

        function openCategoryDeleteDialog(button) {
            categoryDeleteForm.action = button.dataset.deleteUrl;
            categoryDeleteName.textContent = button.dataset.categoryName;
            categoryDeleteDialog.showModal();
        }

        function closeCategoryDeleteDialog() {
            categoryDeleteDialog.close();
        }

        categoryDeleteDialog.addEventListener('click', function (event) {
            if (event.target === categoryDeleteDialog) {
                categoryDeleteDialog.close();
            }
        });
    </script>

</x-layouts.admin>

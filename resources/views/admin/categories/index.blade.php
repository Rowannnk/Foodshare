<x-layouts.public title="Categories - Admin - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-6 px-6 py-14 sm:flex-row sm:items-end lg:px-8">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-[#B96F4D] hover:underline">
                    &larr; Admin
                </a>
                <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                    Food categories
                </h1>
            </div>

            <a href="{{ route('admin.categories.create') }}"
               class="w-fit rounded-full bg-[#E9A17D] px-7 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                + New category
            </a>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        @error('category')
            <p class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                {{ $message }}
            </p>
        @enderror

        <div class="overflow-x-auto rounded-[1.5rem] border border-[#EAD8CD] bg-white">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#EAD8CD] bg-[#FFF8F2] text-xs uppercase tracking-widest text-[#A18F84]">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4">Listings</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAD8CD]">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-[#4A342B]">
                                <a href="{{ route('admin.categories.show', $category) }}" class="hover:underline">
                                    {{ $category->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-[#88766D]">{{ $category->slug }}</td>
                            <td class="px-6 py-4">{{ $category->food_listings_count }}</td>
                            <td class="px-6 py-4">
                                @if ($category->is_active)
                                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-stone-100 px-3 py-1 text-xs font-bold text-stone-500">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="font-semibold text-[#B96F4D] hover:underline">Edit</a>

                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                          onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-[#88766D]">No categories yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-10">
            {{ $categories->links() }}
        </div>
    </section>

</x-layouts.public>
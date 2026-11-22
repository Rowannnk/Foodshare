<x-layouts.public title="Categories - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                Browse by type
            </p>

            <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                Food categories
            </h1>

            <p class="mt-3 max-w-xl text-[#88766D]">
                Choose a category to see what is available right now.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($categories as $category)
                <a href="{{ route('categories.show', $category) }}"
                   class="group rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8 transition hover:-translate-y-1 hover:shadow-xl">

                    <span class="rounded-full bg-[#F7E8DE] px-3 py-1.5 text-xs font-extrabold uppercase tracking-widest text-[#8E583D]">
                        {{ $category->available_count }} available
                    </span>

                    <h2 class="brand-font mt-5 text-2xl font-extrabold text-[#4A342B]">
                        {{ $category->name }}
                    </h2>

                    @if ($category->description)
                        <p class="mt-2 text-sm leading-6 text-[#88766D]">
                            {{ $category->description }}
                        </p>
                    @endif

                    <p class="mt-6 text-sm font-bold text-[#B96F4D] group-hover:underline">
                        See food &rarr;
                    </p>
                </a>
            @empty
                <p class="col-span-full text-[#88766D]">No categories yet.</p>
            @endforelse
        </div>
    </section>

</x-layouts.public>
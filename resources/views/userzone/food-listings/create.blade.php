<x-layouts.public title="New listing - FoodLoop">

    <section class="mx-auto max-w-3xl px-6 py-12 lg:px-8">

        <a href="{{ route('my-listings.index') }}" class="text-sm font-semibold text-[#B96F4D] hover:underline">
            &larr; Back to my listings
        </a>

        <h1 class="brand-font mt-5 text-4xl font-extrabold tracking-tight text-[#4A342B]">
            New listing
        </h1>
        <p class="mt-2 text-[#88766D]">Tell charities what surplus food you have.</p>

        @if ($organizations->isEmpty())
            <div class="mt-8 rounded-2xl bg-[#F7E8DE] px-5 py-4 text-sm text-[#8E583D]">
                You need an active organization before you can publish food.
                <a href="{{ route('organizations.create') }}" class="font-bold underline">Create your organization</a>
            </div>
        @else
            <form method="POST" action="{{ route('my-listings.store') }}"
                  class="mt-8 rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8">
                @csrf

                @include('userzone.food-listings._form', ['listing' => null])

                <div class="mt-8 flex gap-3">
                    <button type="submit"
                            class="rounded-full bg-[#E9A17D] px-8 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                        Publish listing
                    </button>
                    <a href="{{ route('my-listings.index') }}"
                       class="rounded-full border border-[#EAD8CD] px-6 py-3 text-sm font-semibold text-[#806F66] hover:bg-[#FFF3EB]">
                        Cancel
                    </a>
                </div>
            </form>
        @endif
    </section>

</x-layouts.public>
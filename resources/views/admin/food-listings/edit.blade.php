<x-layouts.admin title="Edit Food Listing - Admin - FoodLoop">

    <section class="mx-auto max-w-3xl px-6 py-12 lg:px-8">

        <a href="{{ route('admin.food-listings.index') }}"
            class="text-sm font-semibold text-[#B96F4D] hover:underline">
            &larr; Back to food listings
        </a>

        <h1 class="brand-font mt-5 text-4xl font-extrabold tracking-tight text-[#4A342B]">
            Edit food listing
        </h1>

        <p class="mt-2 text-[#88766D]">
            Update listing information, quantity, or status.
        </p>

        <form method="POST"
            action="{{ route('admin.food-listings.update', $listing) }}"
            enctype="multipart/form-data"
            class="mt-8 rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8">
            @csrf
            @method('PUT')

            @include('admin.food-listings._form', ['listing' => $listing])

            <div class="mt-8 flex gap-3">
                <button type="submit"
                    class="rounded-full bg-[#E9A17D] px-8 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                    Save changes
                </button>

                <a href="{{ route('admin.food-listings.show', $listing) }}"
                    class="rounded-full border border-[#EAD8CD] px-6 py-3 text-sm font-semibold text-[#806F66] hover:bg-[#FFF3EB]">
                    Cancel
                </a>
            </div>
        </form>
    </section>

</x-layouts.admin>

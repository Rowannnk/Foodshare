<x-layouts.public title="New organization - FoodLoop">

    <section class="mx-auto max-w-3xl px-6 py-12 lg:px-8">

        <a href="{{ route('organizations.index') }}" class="text-sm font-semibold text-[#B96F4D] hover:underline">
            &larr; Back to organizations
        </a>

        <h1 class="brand-font mt-5 text-4xl font-extrabold tracking-tight text-[#4A342B]">
            New organization
        </h1>

        <form method="POST" action="{{ route('organizations.store') }}"
              class="mt-8 rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8">
            @csrf

            @include('userzone.organizations._form', ['organization' => null])

            <div class="mt-8 flex gap-3">
                <button type="submit"
                        class="rounded-full bg-[#E9A17D] px-8 py-3 text-sm font-bold text-[#4A342B] transition hover:bg-[#D98E69]">
                    Create organization
                </button>
                <a href="{{ route('organizations.index') }}"
                   class="rounded-full border border-[#EAD8CD] px-6 py-3 text-sm font-semibold text-[#806F66] hover:bg-[#FFF3EB]">
                    Cancel
                </a>
            </div>
        </form>
    </section>

</x-layouts.public>
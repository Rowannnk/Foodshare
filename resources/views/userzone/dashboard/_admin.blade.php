<h2 class="brand-font text-2xl font-extrabold text-[#4A342B]">Manage FoodLoop</h2>
<p class="mt-1 text-sm text-[#88766D]">Go to the admin area to see the platform numbers.</p>

<div class="mt-8 grid gap-6 md:grid-cols-3">
    <a href="{{ route('admin.dashboard') }}"
       class="rounded-[1.75rem] border border-[#E9A17D]/40 bg-[#F7E8DE] p-8 transition hover:-translate-y-1 hover:shadow-xl">
        <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">Admin overview</h3>
        <p class="mt-2 text-sm text-[#806B60]">Platform numbers and shortcuts.</p>
    </a>

    <a href="{{ route('admin.categories.index') }}"
       class="rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8 transition hover:-translate-y-1 hover:shadow-xl">
        <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">Food categories</h3>
        <p class="mt-2 text-sm text-[#88766D]">Add, edit or deactivate categories.</p>
    </a>

    <a href="{{ route('organizations.index') }}"
       class="rounded-[1.75rem] border border-[#EAD8CD] bg-white p-8 transition hover:-translate-y-1 hover:shadow-xl">
        <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">Organizations</h3>
        <p class="mt-2 text-sm text-[#88766D]">See all organizations.</p>
    </a>
</div>
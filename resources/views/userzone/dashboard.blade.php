<x-layouts.public title="Dashboard - FoodLoop">

    <section class="border-b border-[#EAD8CD] bg-white">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-4 px-6 py-12 sm:flex-row sm:items-end lg:px-8">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#B96F4D]">
                    Welcome back
                </p>
                <h1 class="brand-font mt-3 text-4xl font-extrabold tracking-tight text-[#4A342B] sm:text-5xl">
                    Hello, {{ auth()->user()->name }}
                </h1>
            </div>

            <span class="w-fit rounded-full bg-[#F7E8DE] px-4 py-2 text-xs font-extrabold uppercase tracking-widest text-[#8E583D]">
                {{ auth()->user()->isDonor() ? 'Food business' : (auth()->user()->isRecipient() ? 'Charity' : 'Admin') }}
            </span>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        @if (auth()->user()->isAdmin())
            @include('userzone.dashboard._admin')
        @elseif (auth()->user()->isDonor())
            @include('userzone.dashboard._donor')
        @else
            @include('userzone.dashboard._recipient')
        @endif
    </section>

</x-layouts.public>
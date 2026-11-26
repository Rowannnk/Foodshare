@props(['listing'])

<a href="{{ route('food-listings.show', $listing) }}"
   class="group block overflow-hidden rounded-[1.75rem] border border-[#EAD8CD] bg-[#FFF8F2] transition hover:-translate-y-1 hover:shadow-xl">

    <div class="relative h-56 overflow-hidden bg-[#F1D8C8]">
        <img
            src="{{ $listing->photoUrl() }}"
            alt="{{ $listing->title }}"
            loading="lazy"
            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
        >

        <div class="absolute inset-0 bg-gradient-to-t from-[#4A342B]/30 to-transparent"></div>

        <span class="absolute bottom-4 left-4 rounded-full bg-white/95 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-widest text-[#8E583D]">
            {{ $listing->foodCategory->name }}
        </span>
    </div>

    <div class="p-6">
        <h3 class="brand-font text-xl font-extrabold text-[#4A342B]">
            {{ $listing->title }}
        </h3>

        <p class="mt-2 text-sm text-[#88766D]">
            Shared by {{ $listing->organization->name }}
        </p>

        <div class="mt-5 grid grid-cols-2 gap-3 border-t border-[#EAD8CD] pt-5">
            <div>
                <p class="text-xs text-[#A18F84]">Quantity</p>
                <p class="mt-1 text-sm font-bold text-[#4A342B]">{{ $listing->quantity }}</p>
            </div>

            <div>
                <p class="text-xs text-[#A18F84]">Pickup from</p>
                <p class="mt-1 text-sm font-bold text-[#4A342B]">{{ $listing->pickup_from->format('d M, H:i') }}</p>
            </div>
        </div>
    </div>
</a>
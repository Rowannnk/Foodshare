@props(['listing', 'size' => 'h-14 w-14'])

<img src="{{ $listing->photoUrl() }}"
     alt="{{ $listing->title }}"
     loading="lazy"
     {{ $attributes->merge(['class' => $size.' shrink-0 rounded-xl bg-[#F1D8C8] object-cover']) }}>
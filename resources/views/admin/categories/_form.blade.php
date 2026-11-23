@php
    $input = 'mt-2 w-full rounded-2xl border border-[#EAD8CD] bg-[#FFF8F2] px-4 py-3 text-sm focus:border-[#E9A17D] focus:outline-none focus:ring-2 focus:ring-[#E9A17D]/40';
    $label = 'text-sm font-bold text-[#4A342B]';
    $error = 'mt-2 text-sm text-red-600';
@endphp

<div class="space-y-6">

    <div>
        <label for="name" class="{{ $label }}">Name</label>
        <input type="text" id="name" name="name" maxlength="80"
               value="{{ old('name', $category?->name) }}"
               placeholder="For example: Snacks"
               class="{{ $input }}">
        @error('name') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="description" class="{{ $label }}">Description (optional)</label>
        <textarea id="description" name="description" rows="4" class="{{ $input }}">{{ old('description', $category?->description) }}</textarea>
        @error('description') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <input type="hidden" name="is_active" value="0">
        <label class="flex items-center gap-3 text-sm font-bold text-[#4A342B]">
            <input type="checkbox" name="is_active" value="1"
                   class="h-5 w-5 rounded border-[#EAD8CD] text-[#E9A17D] focus:ring-[#E9A17D]"
                   @checked(old('is_active', $category?->is_active ?? true))>
            Active (visitors and donors can use this category)
        </label>
        @error('is_active') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

</div>
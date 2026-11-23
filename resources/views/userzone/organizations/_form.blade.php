@php
    $input = 'mt-2 w-full rounded-2xl border border-[#EAD8CD] bg-[#FFF8F2] px-4 py-3 text-sm focus:border-[#E9A17D] focus:outline-none focus:ring-2 focus:ring-[#E9A17D]/40';
    $label = 'text-sm font-bold text-[#4A342B]';
    $error = 'mt-2 text-sm text-red-600';
@endphp

<div class="grid gap-6 sm:grid-cols-2">

    <div>
        <label for="name" class="{{ $label }}">Name</label>
        <input type="text" id="name" name="name" maxlength="120"
               value="{{ old('name', $organization?->name) }}"
               placeholder="For example: Sunrise Bakery"
               class="{{ $input }}">
        @error('name') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="type" class="{{ $label }}">Type</label>
        <select id="type" name="type" class="{{ $input }}">
            <option value="">Choose...</option>
            @foreach ($types as $type)
                <option value="{{ $type->value }}"
                    @selected(old('type', $organization?->type?->value) === $type->value)>
                    {{ ucfirst($type->value) }}
                </option>
            @endforeach
        </select>
        @error('type') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="contact_email" class="{{ $label }}">Contact email (optional)</label>
        <input type="email" id="contact_email" name="contact_email"
               value="{{ old('contact_email', $organization?->contact_email) }}"
               class="{{ $input }}">
        @error('contact_email') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="contact_phone" class="{{ $label }}">Contact phone (optional)</label>
        <input type="text" id="contact_phone" name="contact_phone" maxlength="30"
               value="{{ old('contact_phone', $organization?->contact_phone) }}"
               class="{{ $input }}">
        @error('contact_phone') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="address" class="{{ $label }}">Address (optional)</label>
        <input type="text" id="address" name="address" maxlength="255"
               value="{{ old('address', $organization?->address) }}"
               class="{{ $input }}">
        @error('address') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="city" class="{{ $label }}">City (optional)</label>
        <input type="text" id="city" name="city" maxlength="100"
               value="{{ old('city', $organization?->city) }}"
               class="{{ $input }}">
        @error('city') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <input type="hidden" name="is_active" value="0">
        <label class="flex items-center gap-3 text-sm font-bold text-[#4A342B]">
            <input type="checkbox" name="is_active" value="1"
                   class="h-5 w-5 rounded border-[#EAD8CD] text-[#E9A17D] focus:ring-[#E9A17D]"
                   @checked(old('is_active', $organization?->is_active ?? true))>
            Active (an inactive organization cannot publish new food)
        </label>
        @error('is_active') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

</div>
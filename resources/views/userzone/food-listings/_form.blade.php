@php
    $input = 'mt-2 w-full rounded-2xl border border-[#EAD8CD] bg-[#FFF8F2] px-4 py-3 text-sm focus:border-[#E9A17D] focus:outline-none focus:ring-2 focus:ring-[#E9A17D]/40';
    $label = 'text-sm font-bold text-[#4A342B]';
    $error = 'mt-2 text-sm text-red-600';
    $dateFormat = 'Y-m-d\TH:i';
@endphp

<div class="grid gap-6 sm:grid-cols-2">

    <div>
        <label for="organization_id" class="{{ $label }}">Organization</label>
        <select id="organization_id" name="organization_id" class="{{ $input }}">
            <option value="">Choose...</option>
            @foreach ($organizations as $organization)
                <option value="{{ $organization->id }}"
                    @selected(old('organization_id', $listing?->organization_id) == $organization->id)>
                    {{ $organization->name }}
                </option>
            @endforeach
        </select>
        @error('organization_id') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="food_category_id" class="{{ $label }}">Category</label>
        <select id="food_category_id" name="food_category_id" class="{{ $input }}">
            <option value="">Choose...</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('food_category_id', $listing?->food_category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('food_category_id') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label for="title" class="{{ $label }}">Title</label>
        <input type="text" id="title" name="title" maxlength="120"
               value="{{ old('title', $listing?->title) }}"
               placeholder="For example: Fresh bread rolls"
               class="{{ $input }}">
        @error('title') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label for="description" class="{{ $label }}">Description (optional)</label>
        <textarea id="description" name="description" rows="4" class="{{ $input }}">{{ old('description', $listing?->description) }}</textarea>
        @error('description') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="quantity" class="{{ $label }}">Quantity</label>
        <input type="number" id="quantity" name="quantity" min="1"
               value="{{ old('quantity', $listing?->quantity) }}"
               class="{{ $input }}">
        @error('quantity') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    @if ($listing)
        <div>
            <label for="status" class="{{ $label }}">Status</label>
            <select id="status" name="status" class="{{ $input }}">
                @foreach (\App\Enums\ListingStatus::cases() as $status)
                    <option value="{{ $status->value }}"
                        @selected(old('status', $listing->status->value) === $status->value)>
                        {{ ucfirst($status->value) }}
                    </option>
                @endforeach
            </select>
            @error('status') <p class="{{ $error }}">{{ $message }}</p> @enderror
        </div>
    @endif

    <div>
        <label for="pickup_from" class="{{ $label }}">Pickup from</label>
        <input type="datetime-local" id="pickup_from" name="pickup_from"
               value="{{ old('pickup_from', $listing?->pickup_from?->format($dateFormat)) }}"
               class="{{ $input }}">
        @error('pickup_from') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="pickup_until" class="{{ $label }}">Pickup until</label>
        <input type="datetime-local" id="pickup_until" name="pickup_until"
               value="{{ old('pickup_until', $listing?->pickup_until?->format($dateFormat)) }}"
               class="{{ $input }}">
        @error('pickup_until') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="expires_at" class="{{ $label }}">Best before</label>
        <input type="datetime-local" id="expires_at" name="expires_at"
               value="{{ old('expires_at', $listing?->expires_at?->format($dateFormat)) }}"
               class="{{ $input }}">
        @error('expires_at') <p class="{{ $error }}">{{ $message }}</p> @enderror
    </div>

</div>
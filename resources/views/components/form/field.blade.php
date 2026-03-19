@props(['label', 'name', 'type' => 'text'])
<label for="{{ $name }}" class="floating-label">
    <input type="{{ $type }}" placeholder="{{ $label }}" name="{{ $name }}" id="{{ $name }}"
        class="input input-md w-full" value="{{ old($name, '') }}" {{ $attributes }} />
    <span>{{ $label }}</span>

    @error($name)
        <p class="text-sm text-error">{{ $message }}</p>
    @enderror
</label>

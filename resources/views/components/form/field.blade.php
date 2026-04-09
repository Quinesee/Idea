@props(['label', 'name', 'type' => 'text', 'value' => null])
<label
    class="floating-label"
    for="{{ $name }}"
>

    @if ($type === 'textarea')
        <textarea
            {{ $attributes }}
            class="textarea w-full"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $label }}"
        >{{ old($name, $value) }}</textarea>
        <span>{{ $label }}</span>
    @else
        <input
            {{ $attributes }}
            class="input input-md w-full"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $label }}"
            type="{{ $type }}"
            value="{{ old($name, $value) }}"
        />
        <span>{{ $label }}</span>
    @endif

    <x-form.error name="{{ $name }}" />
</label>

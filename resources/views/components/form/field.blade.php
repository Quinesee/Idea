@props(['label', 'name', 'type' => 'text'])
<label for="{{ $name }}" class="floating-label">

    @if($type==='textarea')
        <textarea
            placeholder="{{ $label }}"
            id="{{ $name }}"
            name="{{ $name }}"
            class="textarea w-full"
            {{ $attributes }}
        >{{ old($name, '') }}</textarea>
        <span>{{ $label }}</span>
    @else
        <input 
            type="{{ $type }}" 
            placeholder="{{ $label }}" 
            id="{{ $name }}"
            name="{{ $name }}" 
            class="input input-md w-full" value="{{ old($name, '') }}" 
            {{ $attributes }} />
        <span>{{ $label }}</span>
    @endif

    <x-form.error name="{{ $name }}" />
</label>

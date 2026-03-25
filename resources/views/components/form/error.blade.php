@props(['name'])

@error($name)
    <p class="text-sm text-error" role="alert">{{ $message }}</p>
@enderror
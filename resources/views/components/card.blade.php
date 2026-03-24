@props([
    'is' => 'a',
])
<{{ $is }} {{ $attributes->merge(['class' => 'card bg-base-200 block']) }}>
    <div class="card-body">
        {{ $slot }}
    </div>
    </{{ $is }}>

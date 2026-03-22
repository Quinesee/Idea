<a {{ $attributes->merge(['class' => 'card bg-base-200 block', 'href' => '#']) }}>
    <div class="card-body">
        {{ $slot }}
    </div>
</a>

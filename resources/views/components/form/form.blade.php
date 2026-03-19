@props(['title', 'subhead'])

<div class="flex min-h-[calc(90dvh-4rem)] items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center">
            <h1 class="h1">{{ $title }}</h1>
            <p class="subhead">{{ $subhead }}</p>
        </div>
        {{ $slot }}
    </div>
</div>

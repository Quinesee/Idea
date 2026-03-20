@props(['status' => App\IdeaStatus::PENDING->value])

@php
    use App\IdeaStatus;

    $classes = 'badge badge-outline badge-soft block mt-1';

    $classes .= match ($status) {
        IdeaStatus::PENDING->value => ' badge-warning',
        IdeaStatus::IN_PROGRESS->value => ' badge-secondary',
        IdeaStatus::COMPLETED->value => ' badge-success',
        default => ' badge-warning',
    };
@endphp

<span {{ $attributes(['class' => $classes]) }}>{{ $slot }}</span>

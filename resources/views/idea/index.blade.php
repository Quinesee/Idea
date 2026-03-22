<x-layout>
    <header class="py-8">
        <h1 class="h1">Ideas</h1>
        <p class="subhead">Capture your thoughts. Make a plan.</p>
    </header>

    <div>
        <a href="/ideas" class="btn {{ request()->has('status') ? 'btn-ghost' : 'btn-primary' }}">All</a>
        @foreach (App\IdeaStatus::cases() as $status)
            <a href="/ideas?status={{ $status->value }}"
                class="btn {{ request('status') === $status->value ? 'btn-primary' : 'btn-ghost' }}">
                {{ $status->label() }} <span class="text-xs pl-3">{{ $statusCounts->get($status->value) }}</span>
            </a>
        @endforeach
    </div>

    <div class="mt-10">
        <div class="grid md:grid-cols-2 gap-6">
            @forelse ($ideas as $idea)
                <x-card href="{{ route('idea.show', $idea) }}">
                    <div class="card-body">
                        <h3 class="card-title">{{ $idea->title }}</h3>
                        <x-idea.status-label status="{{ $idea->status->value }}">
                            {{ $idea->status->label() }}
                        </x-idea.status-label>
                        <div class="my-1 line-clamp-3 text-neutral-content">{{ $idea->description }}</div>
                        <div>{{ $idea->created_at->diffForHumans() }}</div>
                    </div>
                </x-card>
            @empty
                <x-card class="md:col-span-2">
                    <div class="card-body">
                        <p>No ideas at this time.</p>
                    </div>
                </x-card>
            @endforelse
        </div>
    </div>
</x-layout>

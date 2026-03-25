<x-layout>
    <header class="py-8">
        <h1 class="h1">Ideas</h1>
        <p class="subhead">Capture your thoughts. Make a plan.</p>

        <x-card x-data @click="$dispatch('open-modal', 'create-idea')" is="button"
            class="mt-10 cursor-pointer w-full">
            <div class="h-32 text-left">
                <p>What's the idea?</p>
            </div>
        </x-card>
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
                    <h3 class="card-title">{{ $idea->title }}</h3>
                    <x-idea.status-label status="{{ $idea->status->value }}">
                        {{ $idea->status->label() }}
                    </x-idea.status-label>
                    <div class="my-1 line-clamp-3 text-neutral-content">{{ $idea->description }}</div>
                    <div>{{ $idea->created_at->diffForHumans() }}</div>
                </x-card>
            @empty
                <x-card class="md:col-span-2">
                    <p>No ideas at this time.</p>
                </x-card>
            @endforelse
        </div>
    </div>

    <x-modal name="create-idea" title="New Idea">
        <form x-data="{ status: 'pending' }" action="{{ route('idea.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <x-form.field label="Title" name="title" autofocus required />

                <div class="mb-8">
                    <label for="status" class="label mb-2">Status</label>

                    <div class="join w-full">
                        @foreach (App\IdeaStatus::cases() as $status)
                            <button 
                                @click="status = @js($status->value)"
                                type="button" 
                                class="btn btn-secondary join-item"
                                :class="status === @js($status->value) ? '': 'btn-outline' "
                            >{{ $status->label() }}</button>
                        @endforeach
                    </div>
                    <input type="hidden" name="status" id="status" :value="status">

                    <x-form.error name="status" />
                </div>

                <x-form.field label="Description" name="description" type="textarea" />

                <div class="flex justify-between">
                    <button type="button" class="btn btn-ghost" @click="$dispatch('close-modal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    </x-modal>
</x-layout>

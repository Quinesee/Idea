<x-layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between">
            <a href="{{ route('idea.index') }}" class="flex items-center gap-1 font-bold"><x-icons.arrow-back /> Back to
                ideas</a>

            <div class="flex gap-4">
                <button class="btn btn-outline btn-primary">Edit Idea</button>
                <form method="POST" action="{{ route('idea.destroy', $idea) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline btn-error"
                        onclick="return confirm('Are you sure you want to delete this idea?')">Delete</button>
                </form>
            </div>
        </div>

        <div class="mt-8 space-y-4">

            <h1 class="h1">{{ $idea->title }}</h1>

            <div class="mt-2 flex gap-3 items-center">
                <x-idea.status-label status="{{ $idea->status->value }}">
                    {{ $idea->status->label() }}
                </x-idea.status-label>
                <div class="text-neutral-content">
                    {{ $idea->created_at->diffForHumans() }}
                </div>
            </div>

            <x-card class="mt-6">
                <div class="cursor-pointer">
                    {{ $idea->description }}
                </div>
            </x-card>

            @if ($idea->links->count())
                <div>
                    <h3 class="h3 mb-4">Links</h3>

                    <div class="space-y-2">
                        @foreach ($idea->links as $link)
                            <x-card href="{{ $link }}" class="text-primary">
                                <div class="flex flex-row items-center gap-3">
                                    <x-icons.external-link />
                                    {{ $link }}
                                </div>
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>


</x-layout>

<x-layout>
    <div class="mx-auto max-w-4xl py-8">
        <div class="flex justify-between">
            <a
                class="flex items-center gap-1 font-bold"
                href="{{ route('idea.index') }}"
            ><x-icons.arrow-back /> Back to
                ideas</a>

            <div class="flex gap-4">
                <button class="btn btn-outline btn-primary">Edit Idea</button>
                <form
                    action="{{ route('idea.destroy', $idea) }}"
                    method="POST"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        class="btn btn-outline btn-error"
                        onclick="return confirm('Are you sure you want to delete this idea?')"
                        type="submit"
                    >Delete</button>
                </form>
            </div>
        </div>

        <div class="mt-8 space-y-4">
            @if ($idea->featured_image)
                <div class="overflow-hidden rounded-xl">

                    <img
                        alt="{{ $idea->title }} Featured Image"
                        class="h-auto w-full object-cover"
                        src="{{ asset('storage/' . $idea->featured_image) }}"
                    >
                </div>
            @endif

            <h1 class="h1">{{ $idea->title }}</h1>

            <div class="mt-2 flex items-center gap-3">
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

            @if ($idea->steps->count())
                <div>
                    <h3 class="h3 mb-4">Actionable Steps</h3>

                    <div class="space-y-2">
                        @foreach ($idea->steps as $step)
                            <x-card class="text-secondary">
                                <form
                                    action="{{ route('step.update', $step) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center gap-3">
                                        <button
                                            aria-checked="{{ $step->completed === 1 ? 'true' : 'false' }}"
                                            class="btn btn-square {{ $step->completed === 1 ? 'btn-secondary' : 'btn-outline border-secondary text-base-200' }} btn-sm text-lg"
                                            role="checkbox"
                                            type="submit"
                                        >&check;</button>
                                        <span
                                            class="{{ $step->completed === 1 ? 'text-neutral-content line-through' : '' }}"
                                        >{{ $step->description }}</span>
                                    </div>
                                </form>
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($idea->links->count())
                <div>
                    <h3 class="h3 mb-4">Links</h3>

                    <div class="space-y-2">
                        @foreach ($idea->links as $link)
                            <x-card
                                class="text-primary"
                                href="{{ $link }}"
                            >
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

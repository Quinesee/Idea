<x-layout>
    <header class="py-8">
        <h1 class="h1">Ideas</h1>
        <p class="subhead">Capture your thoughts. Make a plan.</p>

        <x-card
            @click="$dispatch('open-modal', 'create-idea')"
            class="mt-10 w-full cursor-pointer"
            data-test="create-idea-button"
            is="button"
            x-data
        >
            <div class="h-32 text-left">
                <p>What's the idea?</p>
            </div>
        </x-card>
    </header>

    <div>
        <a
            class="btn {{ request()->has('status') ? 'btn-ghost' : 'btn-primary' }}"
            href="/ideas"
        >All</a>
        @foreach (App\IdeaStatus::cases() as $status)
            <a
                class="btn {{ request('status') === $status->value ? 'btn-primary' : 'btn-ghost' }}"
                href="/ideas?status={{ $status->value }}"
            >
                {{ $status->label() }} <span class="pl-3 text-xs">{{ $statusCounts->get($status->value) }}</span>
            </a>
        @endforeach
    </div>

    <div class="mt-10">
        <div class="grid gap-6 md:grid-cols-2">
            @forelse ($ideas as $idea)
                <x-card href="{{ route('idea.show', $idea) }}">
                    @if ($idea->featured_image)
                        <div class="overflow-hidden rounded-xl">
                            <img
                                alt="{{ $idea->title }} Featured Image"
                                class="h-48 w-full object-cover"
                                src="{{ asset('storage/' . $idea->featured_image) }}"
                            >
                        </div>
                    @endif
                    <h3 class="card-title">{{ $idea->title }}</h3>
                    <x-idea.status-label status="{{ $idea->status->value }}">
                        {{ $idea->status->label() }}
                    </x-idea.status-label>
                    <div class="text-neutral-content my-1 line-clamp-3">{{ $idea->description }}</div>
                    <div>{{ $idea->created_at->diffForHumans() }}</div>
                </x-card>
            @empty
                <x-card class="md:col-span-2">
                    <p>No ideas at this time.</p>
                </x-card>
            @endforelse
        </div>
    </div>

    <x-modal
        name="create-idea"
        title="New Idea"
    >
        <form
            action="{{ route('idea.store') }}"
            enctype="multipart/form-data"
            method="POST"
            x-data="{
                status: 'pending',
                newLink: '',
                links: [],
                newStep: '',
                steps: [],
            }"
        >
            @csrf

            <div class="space-y-6">
                <x-form.field
                    autofocus
                    label="Title"
                    name="title"
                    required
                />

                <div class="mb-8">
                    <label
                        class="label mb-2"
                        for="status"
                    >Status</label>

                    <div class="join w-full">
                        @foreach (App\IdeaStatus::cases() as $status)
                            <button
                                :aria-pressed="status === @js($status->value)"
                                :class="status === @js($status->value) ? '' : 'btn-outline'"
                                @click="status = @js($status->value)"
                                class="btn btn-secondary join-item"
                                data-test="button-status-{{ $status->value }}"
                                type="button"
                            >{{ $status->label() }}</button>
                        @endforeach
                    </div>
                    <input
                        :value="status"
                        id="status"
                        name="status"
                        type="hidden"
                    >

                    <x-form.error name="status" />
                </div>

                <x-form.field
                    label="Description"
                    name="description"
                    type="textarea"
                />

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Featured Image</legend>
                    <input
                        accept="image/*"
                        class="file-input w-full"
                        name="image"
                        type="file"
                    />
                    <label class="label">Max size 2MB</label>
                    <x-form.error name="image" />
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Actionable Steps</legend>

                    <template
                        :key="step"
                        x-for="(step, index) in steps"
                    >
                        <div class="flex gap-2">
                            <input
                                class="input w-full"
                                name="steps[]"
                                readonly
                                type="text"
                                x-model="step"
                            />
                            <button
                                @click="steps.splice(index, 1)"
                                aria-label="Remove step"
                                class="btn btn-link btn-square"
                                type="button"
                            ><x-icons.close /></button>
                        </div>
                    </template>

                    <div class="flex gap-2">
                        <input
                            class="input w-full"
                            data-test="new-step"
                            id="new-step"
                            placeholder="Gather materials..."
                            type="text"
                            x-model="newStep"
                        />
                        <button
                            :disabled="newStep.trim().length === 0"
                            @click="steps.push(newStep.trim()); newStep = ''"
                            aria-label="Add new step"
                            class="btn btn-link btn-square"
                            data-test="submit-new-step-button"
                            type="button"
                        ><x-icons.close class="rotate-45" /></button>
                    </div>
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Links</legend>

                    <template
                        :key="link"
                        x-for="(link, index) in links"
                    >
                        <div class="flex gap-2">
                            <input
                                class="input w-full"
                                name="links[]"
                                readonly
                                type="text"
                                x-model="link"
                            />
                            <button
                                @click="links.splice(index, 1)"
                                aria-label="Remove link"
                                class="btn btn-link btn-square"
                                type="button"
                            ><x-icons.close /></button>
                        </div>
                    </template>

                    <div class="flex gap-2">
                        <input
                            autocomplete="url"
                            class="input w-full"
                            data-test="new-link"
                            id="new-link"
                            placeholder="https://example.com"
                            spellcheck="false"
                            type="url"
                            x-model="newLink"
                        />
                        <button
                            :disabled="newLink.trim().length === 0"
                            @click="links.push(newLink.trim()); newLink = ''"
                            aria-label="Add new link"
                            class="btn btn-link btn-square"
                            data-test="submit-new-link-button"
                            type="button"
                        ><x-icons.close class="rotate-45" /></button>
                    </div>
                </fieldset>

                <div class="flex justify-between">
                    <button
                        @click="$dispatch('close-modal')"
                        class="btn btn-ghost"
                        type="button"
                    >Cancel</button>
                    <button
                        class="btn btn-primary"
                        type="submit"
                    >Create</button>
                </div>
            </div>
        </form>
    </x-modal>
</x-layout>

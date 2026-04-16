@props(['idea' => new App\Models\Idea()])

<x-modal
    name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}"
    title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}"
>
    <form
        :enctype="hasImage ? 'multipart/form-data' : false"
        action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        method="POST"
        x-data="{
            status: @js(old('status', $idea->status->value)),
            newLink: '',
            links: @js(old('links', $idea->links ?? [])),
            newStep: '',
            steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed']))),
            hasImage: false,
        }"
    >
        @csrf

        @if ($idea->exists)
            @method('PATCH')
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-6">
            <x-form.field
                :value="$idea->title"
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
                :value="$idea->description"
                label="Description"
                name="description"
                type="textarea"
            />

            <fieldset class="fieldset">
                <legend class="fieldset-legend">Featured Image</legend>

                @if ($idea->featured_image)
                    <div class="mb-2 space-y-2 overflow-hidden rounded-xl">

                        <img
                            alt="{{ $idea->title }} Featured Image"
                            class="h-auto w-full object-cover"
                            src="{{ asset('storage/' . $idea->featured_image) }}"
                        >

                        <button
                            class="btn btn-outline w-full"
                            form="delete-image-form"
                        >Remove Image</button>
                    </div>
                @endif

                <input
                    @change="hasImage = $event.target.files.length > 0"
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
                    :key="step.id || index"
                    x-for="(step, index) in steps"
                >
                    <div class="flex gap-2">
                        <input
                            :name="`steps[${index}][description]`"
                            :value="step.description"
                            class="input w-full"
                            readonly
                            type="text"
                        />
                        <input
                            :name="`steps[${index}][completed]`"
                            :value="step.completed ? '1' : '0'"
                            type="hidden"
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
                        @click="
                            steps.push({description: newStep.trim(), completed: false}); 
                            newStep = '';
                        "
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
                >{{ $idea->exists ? 'Update' : 'Create' }}</button>
            </div>
        </div>
    </form>

    @if ($idea->featured_image)
        <form
            action="{{ route('idea.image.destroy', $idea) }}"
            id="delete-image-form"
            method="POST"
        >
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>

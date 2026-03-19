<x-layout>
    <x-form title="Register an account" subhead="Start tracking your ideas today!">
        <form action="/register" method="POST" class="mt-10 space-y-4">
            @csrf

            <x-form.field label="Your Name" name="name" />

            <x-form.field label="Your Email" name="email" type="email" />

            <x-form.field label="Password" name="password" type="password" />

            <button class="btn btn-primary">Create account</button>

        </form>
    </x-form>
</x-layout>

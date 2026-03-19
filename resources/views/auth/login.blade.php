<x-layout>
    <x-form title="Log in" subhead="Welcome back">
        <form action="/login" method="POST" class="mt-10 space-y-4">
            @csrf

            <x-form.field label="Your Email" name="email" type="email" />

            <x-form.field label="Password" name="password" type="password" />

            <button class="btn btn-primary">Sign in</button>

        </form>
    </x-form>
</x-layout>

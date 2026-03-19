<div class="navbar bg-base-100 shadow-sm">

    <div class="flex-1">
        <a class="btn btn-ghost" href="/"><img src="{{ asset('images/idea-logo.svg') }}" alt="Idea Logo"
                class="w-20" /></a>
    </div>
    <div class="flex-none">
        <ul class="menu menu-horizontal px-1 gap-4">
            @auth
                <form action="/logout" method="POST">
                    @csrf

                    <button class="btn btn-secondary" type="submit">Log out</button>
                </form>
            @endauth

            @guest
                <li><a href="/login" class="btn">Sign In</a></li>
                <li><a href="/register" class="btn btn-primary">Register</a></li>
            @endguest
        </ul>

    </div>
</div>

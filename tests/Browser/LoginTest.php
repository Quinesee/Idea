<?php

declare(strict_types=1);

use App\Models\User;

it('logs in a user', function () {
    $user = User::factory()->create(['password' => 'password1234']);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password1234')
        ->click('@login-button')
        ->assertPathIs('/');

    $this->assertAuthenticated();
});

it('logs out a user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/')
        ->click('Log out')
        ->assertPathIs('/');

    $this->assertGuest();
});

it('requires valid credentials to log in', function () {
    User::factory()->create();

    visit('/login')
        ->fill('email', 'test@email.com')
        ->fill('password', 'password1234')
        ->click('@login-button')
        ->assertPathIs('/login')
        ->assertSee('Unable to authenticate using the provided credentials');

    $this->assertGuest();
});

it('redirects logged in user from /login to /', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/login')
        ->assertPathIs('/');

    $this->assertAuthenticated();
});

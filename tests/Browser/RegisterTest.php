<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;

it('registers a user', function () {
    visit('/register')
        ->fill('name', 'Jane Doe')
        ->fill('email', 'jane@test.com')
        ->fill('password', 'password1234')
        ->click('Create account')
        ->assertPathIs('/ideas');

    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name' => 'Jane Doe',
        'email' => 'jane@test.com',
    ]);
});

it('requires a name with min of 3 characters', function () {
    visit('/register')
        ->fill('name', 'Jo')
        ->fill('email', 'jane@email.com')
        ->fill('password', 'password1234')
        ->click('Create account')
        ->assertPathIs('/register')
        ->assertSee('The name field must be at least 3 characters.');
});

it('requires a valid email', function () {
    visit('/register')
        ->fill('name', 'Jane Doe')
        ->fill('email', 'jane email')
        ->fill('password', 'password1234')
        ->click('Create account')
        ->assertPathIs('/register');
});

it('requires a password with min of 8 characters', function () {
    visit('/register')
        ->fill('name', 'Jane Doe')
        ->fill('email', 'jane@test.com')
        ->fill('password', '1234')
        ->click('Create account')
        ->assertPathIs('/register')
        ->assertSee('The password field must be at least 8 characters.');
});

it('requires a unique email', function () {
    User::factory()->create(['email' => 'jane@test.com']);

    visit('/register')
        ->fill('name', 'Jane Doe')
        ->fill('email', 'jane@test.com')
        ->fill('password', 'password1234')
        ->click('Create account')
        ->assertPathIs('/register')
        ->assertSee('The email has already been taken.');
});

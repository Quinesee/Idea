<?php

use App\Models\Idea;
use App\Models\User;

it('belongs to a user', function () {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);
});

it('can have steps', function () {
    $idea = Idea::factory()->create();

    expect($idea->steps)->toBeEmpty();

    $idea->steps()->create([
        'description' => 'Step 1',
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);
});

it('creates a new idea', function () {
    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Example title')
        ->click('@button-status-in_progress')
        ->fill('description', 'Example description')
        ->fill('@new-link', 'https://test.com')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://example.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Step 1')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'Step 2')
        ->click('@submit-new-step-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Example title',
        'status' => 'in_progress',
        'description' => 'Example description',
        'links' => ['https://test.com', 'https://example.com'],
    ]);

    expect($idea->steps()->pluck('description')->toArray())
        ->toBe(['Step 1', 'Step 2']);
});


it('edits an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->create([
        'user_id' => $user->id,
    ]);

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Example title')
        ->click('@button-status-in_progress')
        ->fill('description', 'Example description')
        ->fill('@new-link', 'https://test.com')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://example.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Step 1')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'Step 2')
        ->click('@submit-new-step-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Example title',
        'status' => 'in_progress',
        'description' => 'Example description',
        'links' => ['https://test.com', 'https://example.com'],
    ]);

    expect($idea->steps()->pluck('description')->toArray())
        ->toBe(['Step 1', 'Step 2']);
});

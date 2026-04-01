<?php

use App\Models\User;

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
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'Example title',
        'status' => 'in_progress',
        'description' => 'Example description',
        'links' => ['https://test.com', 'https://example.com'],
    ]);
});

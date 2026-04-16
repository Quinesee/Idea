<?php

use App\Models\Idea;
use App\Models\User;

it('shows the initial state', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->create([
        'user_id' => $user->id,
    ]);

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->assertValue('title', $idea->title)
        ->assertValue('description', $idea->description)
        ->assertValue('status', $idea->status->value)
        ->assertValue('links[]', $idea->links[0]);
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
        ->fill('@new-step', 'Step 1')
        ->click('@submit-new-step-button')
        ->click('Update')
        ->assertRoute('idea.show', [$idea]);

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Example title',
        'status' => 'in_progress',
        'description' => 'Example description',
        'links' => [$idea->links[0], 'https://test.com'],
    ]);

    expect($idea->steps)->toHaveCount(1);
});

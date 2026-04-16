<?php

use App\Models\Idea;
use App\Models\User;

it('required authentication to destroy idea', function () {
    $idea = Idea::factory()->create();

    $this->delete(route('idea.destroy', $idea))->assertRedirectToRoute('login');
});

it('allows destroying idea owned by user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $idea = Idea::factory()->create(['user_id' => $user->id]);

    $this->delete(route('idea.destroy', $idea))->assertRedirectToRoute('idea.index');

    $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
});

it('disallows destroying idea not owned by user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $idea = Idea::factory()->create();

    $this->delete(route('idea.destroy', $idea))->assertForbidden();
});

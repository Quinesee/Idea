<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Idea;
use Illuminate\Support\Facades\DB;

class UpdateIdea
{
    public function handle(array $attributes, Idea $idea): void
    {
        $data = collect($attributes)->only([
            'title',
            'description',
            'status',
            'links',
        ])->toArray();

        // TODO: Handle image update and deletion
        // Check if image already exists and delete if new image is uploaded
        if ($attributes['image'] ?? false) {
            $data['featured_image'] = $attributes['image']->store('images', 'public');
        }

        DB::transaction(function () use ($data, $attributes, $idea) {

            $idea->update($data);

            $idea->steps()->delete();

            $idea->steps()->createMany($attributes['steps'] ?? []);
        });
    }
}

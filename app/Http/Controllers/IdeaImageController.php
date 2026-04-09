<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class IdeaImageController extends Controller
{
    public function destroy(Idea $idea)
    {
        //authorize
        Gate::authorize('workWith', $idea);

        Storage::disk('public')->delete($idea->featured_image);
        $idea->update(['featured_image' => null]);

        return back();
    }
}

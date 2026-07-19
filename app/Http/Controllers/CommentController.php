<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, User $user, Post $post)
    {
        $post->comments()->create([
            'content' => $request->input('content'),
            'author_id' => auth()->id(),
        ]);

        return redirect()->route('author.posts.show', [$user, $post]);
    }
}

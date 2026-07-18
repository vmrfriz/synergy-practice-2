<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Post $post): bool
    {
        return $post->deleted_at === null;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Post $post): bool
    {
        return $post->author_id === $user->id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $post->author_id === $user->id;
    }

    public function restore(User $user, Post $post): bool
    {
        return $user->admin;
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->admin;
    }
}

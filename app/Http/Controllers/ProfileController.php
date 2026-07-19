<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function show(): Response
    {
        $user = auth()->user();

        $subscriptions = $user->subscriptions()
            ->withCount('posts')
            ->paginate();
        $subscriptions->getCollection()
            ->each
            ->append('subscribed');

        return Inertia::render('Profile', [
            'user' => $user,
            'posts' => $user->posts()
                ->withOnly(['comments'])
                ->paginate(),
            'subscriptions' => $subscriptions,
            'feedPosts' => $user->feed()
                ->paginate(),
        ]);
    }

    public function subscribe(User $user)
    {
        $currentUser = auth()->user();
        if ($currentUser->id === $user->id) {
            return back()->withErrors(['message' => 'Вы не можете подписаться на самого себя']);
        }

        if (Subscription::subscribed($currentUser->id, $user->id)) {
            return back()->withErrors(['message' => 'Вы уже подписаны']);
        }

        $currentUser->subscriptions()->attach($user);
        return back()->with('success', "Вы подписались на пользователя {$user->name}");
    }

    public function unsubscribe(User $user)
    {
        $currentUser = auth()->user();
        if ($currentUser->id === $user->id) {
            return back()->withErrors(['message' => 'Вы не можете отписаться от самого себя']);
        }

        if (!Subscription::subscribed($currentUser->id, $user->id)) {
            return back()->withErrors(['message' => 'Вы не подписаны на этого пользователя']);
        }

        $currentUser->subscriptions()->detach($user);
        return back()->with('success', "Вы отписались от пользователя {$user->name}");
    }
}

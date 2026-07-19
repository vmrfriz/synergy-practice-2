<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show'])
        ];
    }

    public function index(): Response
    {
        return Inertia::render('Post/Index', [
            'title' => "Свежие записи блога",
            'posts' => Post::query()->paginate(),
        ]);
    }

    public function author(User $user): Response
    {
        return Inertia::render('Post/Index', [
            'title' => "Записи пользователя {$user->name}",
            'posts' => $user->posts()->paginate(),
        ]);
    }

    public function tag(Tag $tag): Response
    {
        return Inertia::render('Post/Index', [
            'title' => "Записи по тегу {$tag->name}",
            'posts' => $tag->posts()->paginate(),
        ]);
    }

    public function show(User $user, Post $post): Response
    {
        if ($post->author->id !== $user->id) {
            abort(404, 'У пользователя нет такой записи.');
        }

        $post->loadMissing('comments');

        return Inertia::render('Post/Show', [
            'post' => $post,
            'can_edit' => Gate::check('edit', $post),
            'can_delete' => Gate::check('delete', $post),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Post/Create');
    }

    public function store(StorePost $request): RedirectResponse
    {
        $post = DB::transaction(static function () use ($request) {
            $post = new Post([
                ...$request->only('title', 'content'),
                'author' => auth()->id(),
            ]);
            $post->save();
            $post->tags()->sync($request->tags);
            return $post;
        });

        return redirect()->route('posts.show', [$post]);
    }

    public function edit(Post $post): Response
    {
        $this->assertAuthor($post);

        return Inertia::render('Post/Edit');
    }

    public function update(StorePost $request, Post $post): RedirectResponse
    {
        DB::transaction(static function () use ($post, $request) {
            $post->update($request->only(['title', 'content']));
            $post->tags()->sync($request->tags);
        });

        return redirect()->route('posts.edit', [$post]);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->assertAuthor($post);

        return redirect()->route('posts.index');
    }

    private function assertAuthor(Post $post): void
    {
        $ok = auth()->check()
            && auth()->user()->id === $post->author?->id;

        if (!$ok) {
            abort(403, 'Вы не автор этой записи');
        }
    }
}

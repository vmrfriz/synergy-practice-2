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
        Gate::authorize('viewAny', Post::class);

        return Inertia::render('Post/Index', [
            'title' => "Свежие записи блога",
            'author' => null,
            'posts' => Post::query()->paginate(),
        ]);
    }

    public function author(User $user): Response
    {
        Gate::authorize('viewAny', Post::class);

        return Inertia::render('Post/Index', [
            'title' => "Записи пользователя {$user->name}",
            'author' => $user->append('subscribed'),
            'posts' => $user->posts()->paginate(),
        ]);
    }

    public function tag(Tag $tag): Response
    {
        Gate::authorize('viewAny', Post::class);

        return Inertia::render('Post/Index', [
            'title' => "Записи по тегу {$tag->name}",
            'author' => null,
            'posts' => $tag->posts()->paginate(),
        ]);
    }

    public function show(User $user, Post $post): Response
    {
        Gate::authorize('view', $post);

        if ($post->author->id !== $user->id) {
            abort(404, 'У пользователя нет такой записи.');
        }

        $post->loadMissing('comments.author');
        $post->author->append('subscribed');

        return Inertia::render('Post/Show', [
            'post' => $post,
            'can_edit' => Gate::check('edit', $post),
            'can_delete' => Gate::check('delete', $post),
        ]);
    }

    public function create(): Response
    {
        Gate::authorize('create', Post::class);

        return Inertia::render('Post/Create', [
            'tags' => Tag::query()->pluck('name')->toArray()
        ]);
    }

    public function store(StorePost $request): RedirectResponse
    {
        $user = auth()->user();

        $post = DB::transaction(function () use ($request, $user) {
            $post = Post::create([
                'title' => $request->title,
                'content' => $request->input('content'),
                'hidden' => $request->boolean('hidden'),
                'author_id' => $user->id,
            ]);

            $tagIds = collect($request->array('tags'))
                ->map(fn(array $tag) =>
                    Tag::firstOrCreate(['name' => $tag['name']], ['created_by' => $user->id])->id
                );

            $post->tags()->sync($tagIds);

            return $post;
        });

        return redirect()->route('author.posts.show', [$user, $post]);
    }

    public function edit(Post $post): Response
    {
        Gate::authorize('edit', $post);

        return Inertia::render('Post/Edit', [
            'post' => $post,
            'tags' => Tag::query()->pluck('name')->toArray(),
        ]);
    }

    public function update(StorePost $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);

        DB::transaction(static function () use ($post, $request) {
            $post->update($request->only(['title', 'content']));
            $post->tags()->sync($request->tags);
        });

        return redirect()->route('author.posts.edit', [$post]);
    }

    public function destroy(User $user, Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);

        return redirect()->route('profile');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Resources\PostListResource;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
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
            new Middleware('auth', except: ['index', 'author', 'tag', 'show'])
        ];
    }

    public function index(): Response
    {
        Gate::authorize('viewAny', Post::class);

        return Inertia::render('Post/Index', [
            'title' => "Свежие записи блога",
            'author' => null,
            'posts' => PostListResource::collection(
                Post::query()->paginate()
            ),
        ]);
    }

    public function author(User $user): Response
    {
        Gate::authorize('viewAny', Post::class);

        return Inertia::render('Post/Index', [
            'title' => "Записи пользователя {$user->name}",
            'author' => $user->append('subscribed'),
            'posts' => PostListResource::collection(
                $user->posts()->paginate()
            ),
        ]);
    }

    public function tag(Tag $tag): Response
    {
        Gate::authorize('viewAny', Post::class);

        return Inertia::render('Post/Index', [
            'title' => "Записи по тегу {$tag->name}",
            'author' => null,
            'posts' => PostListResource::collection(
                $tag->posts()->paginate()
            ),
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
            $post = new Post(
                $request->only(['title', 'slug', 'content', 'hidden'])
            );
            $post->author_id = $user->id;
            $post->save();

            $tagIds = collect($request->array('tags'))
                ->map(fn(string $tag) =>
                    Tag::firstOrCreate(['name' => $tag], ['created_by' => $user->id])->id
                );

            $post->tags()->sync($tagIds);

            return $post;
        });

        return redirect()->route('author.posts.show', [$user, $post]);
    }

    public function edit(User $user, Post $post): Response
    {
        Gate::authorize('edit', $post);

        return Inertia::render('Post/Edit', [
            'post' => $post,
            'tags' => Tag::query()->pluck('name')->toArray(),
        ]);
    }

    public function update(StorePost $request, User $user, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);

        DB::transaction(static function () use ($user, $post, $request) {
            $post->update(
                $request->only(['title', 'slug', 'content', 'hidden'])
            );

            $tagIds = collect($request->array('tags'))
                ->map(fn(string $tag) =>
                    Tag::firstOrCreate(['name' => $tag], ['created_by' => $user->id])->id
                );

            $post->tags()->sync($tagIds);
        });

        return redirect()
            ->route('author.posts.edit', [$user, $post])
            ->with('success', 'Изменения сохранены');
    }

    public function destroy(User $user, Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);

        return $post->delete()
            ? redirect()->route('profile')->with('success', 'Запись удалена')
            : redirect()->route('profile')->withErrors('Не удалось удалить запись');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $tags = Tag::query()->pluck('id');

        $posts_count = 12;

        Post::factory()
            ->state(new Sequence(
                fn (Sequence $sequence) => [
                    'created_at' => fake()->dateTimeBetween(
                        now()->subWeeks($posts_count - $sequence->index)->subDays(6)->startOfDay(),
                        now()->subWeeks($posts_count - $sequence->index)->startOfDay(),
                    )
                ]
            ))
            ->count($posts_count)
            ->recycle($users)
            ->create()
            ->each(function (Post $post) use ($tags) {
                $ids = $tags->random(rand(0, 5))->toArray();
                $post->tags()->attach($ids);
            });
    }
}

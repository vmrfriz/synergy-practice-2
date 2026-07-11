<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = User::factory(3)->create();
        $tags = Tag::factory()->count(10)->create();
        Post::factory()
            ->count(12)
            ->recycle($users)
            ->hasAttached($tags, [], 'tags')
            ->create()
            ->each(function ($post) use ($tags) {
                $post->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('ulid')
                );
            });
    }
}

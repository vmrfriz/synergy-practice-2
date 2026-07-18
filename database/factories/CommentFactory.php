<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'post_id' => Post::inRandomOrder()->first(),
            'author_id' => User::inRandomOrder()->first(),
            'content' => $this->faker->paragraph(),
            'created_at' => function (array $attributes) {
                $post = Post::find($attributes['post_id']);
                return $this->faker->dateTimeBetween($post->created_at, now());
            },
            'updated_at' => fn(array $attributes) => $attributes['created_at'],
        ];
    }
}

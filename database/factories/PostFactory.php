<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

#[UseModel(Post::class)]
class PostFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'slug' => fn (array $attributes) => Str::slug($attributes['title']),
            'author_id' => User::query()->inRandomOrder()->first() ?? User::factory(),
            'title' => $this->faker->unique()->sentence(),
            'content' => $this->faker->paragraphs(asText: true),
            'hidden' => false,
            'created_at' => $this->faker->dateTimeBetween(now()->subYears(5), now()->subHour()),
            'updated_at' => fn (array $attributes) => $attributes['created_at'],
        ];
    }
}

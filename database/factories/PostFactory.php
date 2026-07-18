<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

#[UseModel(Post::class)]
class PostFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'author_id' => User::query()->inRandomOrder()->first() ?? User::factory(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(asText: true),
            'hidden' => false,
        ];
    }
}

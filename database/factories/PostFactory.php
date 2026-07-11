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
            'ulid' => Str::ulid(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(asText: true),
            'author_id' => User::query()->inRandomOrder()->first() ?? User::factory(),
        ];
    }
}

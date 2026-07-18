<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function (User $user) {
            if (rand(0, 2) === 0) {
                return;
            }

            $authors = User::query()
                ->whereNot('id', $user->id)
                ->inRandomOrder()
                ->limit(rand(1, 10))
                ->pluck('id')
                ->toArray();
            $user->subscriptions()->attach($authors);
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (User::query()->exists()) {
            return;
        }

        $password = Hash::make('password');

        User::factory()->create([
            'email' => 'admin@synergy.ru',
            'password' => $password,
        ]);

        User::factory()->create([
            'email' => 'shitpost@vk.ru',
            'password' => $password,
        ]);

        User::factory()->create([
            'password' => $password,
        ]);
    }
}

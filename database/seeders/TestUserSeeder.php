<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Test', 'email' => 'test@test.com', 'password' => \Illuminate\Support\Facades\Hash::make('password')],
        ];

        \App\Models\User::upsert($users, ['name'], ['email', 'password']);
    }
}

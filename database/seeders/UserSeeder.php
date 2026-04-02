<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );

        User::factory()->count(10)->create();
    }
}

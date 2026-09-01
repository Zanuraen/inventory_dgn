<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@inventory.test'],
            [
                'name' => 'Admin',
                'password' => 'password123',
            ]
        );
    }
}
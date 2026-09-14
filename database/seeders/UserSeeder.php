<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Dicari berdasarkan 'name' (bukan 'email'), karena login sistem
        // ini memang pakai name sebagai username, dan supaya jalan ulang
        // seeder ini tidak bikin akun dobel kalau namanya sudah ada.
        User::updateOrCreate(
            ['name' => 'Admin Pusat'],
            ['password' => 'pusat123'] // otomatis ke-hash lewat $casts di User.php
        );

        User::updateOrCreate(
            ['name' => 'Admin Kantor'],
            ['password' => 'kantor123']
        );
    }
}
<?php

namespace Database\Seeders;

use App\Models\AssetHandover;
use Illuminate\Database\Seeder;

class AssetHandoverSeeder extends Seeder
{
    public function run(): void
    {
        AssetHandover::factory()->count(20)->create();
    }
}
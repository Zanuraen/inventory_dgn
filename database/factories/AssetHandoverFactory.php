<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetHandoverFactory extends Factory
{
    public function definition(): array
    {
        $tanggalPinjam = $this->faker->dateTimeBetween('-1 year', 'now');

        return [
            'asset_id' => Asset::inRandomOrder()->first()?->id ?? Asset::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'tujuan_penggunaan' => $this->faker->randomElement(['Kerja lapangan', 'Kebutuhan proyek', 'Pengganti unit rusak', 'Kebutuhan WFH']),
            'tanggal_pinjam' => $tanggalPinjam->format('Y-m-d'),
            'tanggal_kembalian' => $this->faker->boolean(60)
                ? $this->faker->dateTimeBetween($tanggalPinjam, 'now')->format('Y-m-d')
                : null,
            'notes' => $this->faker->optional()->sentence(),
            'file_path' => null,
        ];
    }
}
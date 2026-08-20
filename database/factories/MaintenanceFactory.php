<?php

namespace Database\Factories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement(['terjadwal', 'terlambat', 'selesai']);
        $maintenanceDate = $this->faker->dateTimeBetween('-6 months', '+1 month');
        $asset = Asset::inRandomOrder()->first() ?? Asset::factory()->create();

        return [
            'asset_id' => $asset->id,
            'maintenance_date' => $maintenanceDate->format('Y-m-d'),
            'description' => $this->faker->sentence(),
            'jenis_pemeliharaan' => $this->jenisPemeliharaanFor($asset->category?->name),
            'jatuh_tempo' => (clone $maintenanceDate)->modify('+30 days')->format('Y-m-d'),
            'cost' => $this->faker->numberBetween(50000, 2000000),
            'vendor' => $this->faker->company(),
            'kontak_vendor' => $this->faker->phoneNumber(),
            'status' => $status,
        ];
    }

    private function jenisPemeliharaanFor(?string $categoryName): string
    {
        return match ($categoryName) {
            'elektronik' => $this->faker->randomElement(['Update Software', 'Pembersihan Hardware', 'Penggantian Baterai']),
            'jaringan dan listrik' => $this->faker->randomElement(['Cek Konektivitas', 'Penggantian Kabel', 'Reset Konfigurasi']),
            'meubelair' => $this->faker->randomElement(['Perbaikan Struktur', 'Pengecatan Ulang', 'Penggantian Roda/Engsel']),
            'perlengkapan RT' => $this->faker->randomElement(['Servis Rutin', 'Pengisian Freon', 'Pembersihan Filter']),
            default => 'Pemeliharaan Umum',
        };
    }
}
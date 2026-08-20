<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    public function definition(): array
    {
        $itemsByCategory = [
            'elektronik' => ['Laptop Asus', 'Laptop Lenovo', 'Monitor LG 24"', 'Printer Epson', 'Proyektor Epson', 'PC Desktop'],
            'jaringan dan listrik' => ['Router Mikrotik', 'Switch TP-Link', 'Stabilizer', 'Kabel LAN', 'UPS APC', 'Access Point'],
            'meubelair' => ['Kursi Kantor', 'Meja Kantor', 'Lemari Arsip', 'Rak Buku', 'Sofa Tamu'],
            'perlengkapan RT' => ['Dispenser', 'Kipas Angin', 'AC Split', 'Rice Cooker', 'Galon Air'],
        ];

        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
        $itemPool = $itemsByCategory[$category->name] ?? ['Barang Umum'];
        $itemName = $this->faker->randomElement($itemPool);

        return [
            'category_id' => $category->id,
            'name' => $itemName,
            'code_asset' => 'DGN-' . $this->faker->unique()->numerify('####'),
            'serial_number' => strtoupper($this->faker->bothify('SN-????-####')),
            'spesifikasi' => $this->specifikasiFor($category->name),
            'condition_status' => $this->faker->randomElement(['Baik', 'Rusak Ringan', 'Rusak Berat']),
            'qty' => $this->faker->numberBetween(1, 10),
            'pengguna' => $this->faker->name(),
            'location' => $this->faker->randomElement(['Ruang IT', 'Ruang HRD', 'Ruang Meeting', 'Gudang', 'Ruang Direktur', 'Pantry']),
            'tanggal_beli' => $this->faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'harga_beli' => $this->faker->numberBetween(150000, 25000000),
            'image' => null,
            'description' => $this->faker->sentence(),
        ];
    }

    private function specifikasiFor(string $categoryName): string
    {
        return match ($categoryName) {
            'elektronik' => $this->faker->randomElement(['Core i5, RAM 8GB, SSD 256GB', 'Core i7, RAM 16GB, SSD 512GB', '24 inch, Full HD']),
            'jaringan dan listrik' => $this->faker->randomElement(['300 Mbps, 4 port', '1000VA', 'Cat6, 20 meter']),
            'meubelair' => $this->faker->randomElement(['Bahan kayu ', 'bahan besi+busa', 'Kapasitas 3 orang',]),
            'perlengkapan RT' => $this->faker->randomElement(['1 PK', '19 liter', 'Kapasitas 1.8L']),
            default => $this->faker->sentence(3),
        };
    }
}
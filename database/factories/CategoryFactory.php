<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;

        $categories = ['elektronik', 'jaringan dan listrik', 'meubelair', 'perlengkapan RT'];
        $name = $categories[$index % count($categories)];
        $index++;

        return [
            'name' => $name,
            'code' => strtoupper(substr(str_replace(' ', '', $name), 0, 5)) . '-' . str_pad($index, 3, '0', STR_PAD_LEFT),
            'description' => $this->faker->sentence(),
        ];
    }
}
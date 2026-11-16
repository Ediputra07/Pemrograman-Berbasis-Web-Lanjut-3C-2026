<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kategori_id' => Kategori::factory(),

            'judul' => fake()->words(3, true),

            'penulis' => fake()->name(),

            'tahun_terbit' => fake()->numberBetween(2000, 2025),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    protected $model = Buku::class;

    public function definition(): array
    {
        return [
            'kategori_id' => Kategori::factory(),
            'judul' => fake()->sentence(3),
            'penulis' => fake()->name(),
            'penerbit' => fake()->company(), // Sinkron dengan database
            'tahun_terbit' => fake()->year(),
        ];
    }
}
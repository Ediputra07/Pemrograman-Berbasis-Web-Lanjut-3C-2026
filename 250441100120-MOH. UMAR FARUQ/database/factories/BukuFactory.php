<?php

namespace Database\Factories;

use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'kategori_id' => \App\Models\Kategori::inRandomOrder()->first()?->id ?? \App\Models\Kategori::factory(),
        'judul' => fake()->sentence(3),
        'penulis' => fake()->name(),
        'tahun_terbit' => fake()->year(),
    ]; 
}
}

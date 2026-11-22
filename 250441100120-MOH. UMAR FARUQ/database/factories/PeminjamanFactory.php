<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'anggota_id' => \App\Models\Anggota::inRandomOrder()->first()?->id ?? \App\Models\Anggota::factory(),
        'buku_id' => \App\Models\Buku::inRandomOrder()->first()?->id ?? \App\Models\Buku::factory(),
        'tanggal_pinjam' => fake()->date(),
        'tanggal_kembali' => fake()->optional()->date(),
    ];
}
}

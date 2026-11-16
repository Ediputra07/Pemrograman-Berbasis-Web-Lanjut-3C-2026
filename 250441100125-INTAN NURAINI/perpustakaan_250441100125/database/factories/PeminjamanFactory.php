<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'anggota_id' => Anggota::query()->inRandomOrder()->value('id'),
            'buku_id' => Buku::query()->inRandomOrder()->value('id'),
            'tanggal_pinjam' => fake()->date(),
            'tanggal_kembali' => fake()->optional()->date(),
        ];
    }
}
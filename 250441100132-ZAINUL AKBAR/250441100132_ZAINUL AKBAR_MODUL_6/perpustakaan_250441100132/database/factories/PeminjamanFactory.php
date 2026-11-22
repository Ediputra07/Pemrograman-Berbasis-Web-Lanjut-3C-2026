<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;

    public function definition(): array
    {
        return [
            'anggota_id' => Anggota::factory(), // Otomatis ambil/buat ID dari Anggota
            'buku_id' => Buku::factory(),       // Otomatis ambil/buat ID dari Buku
            'tanggal_pinjam' => fake()->date(),
            'tanggal_kembali' => fake()->dateTimeBetween('+1 week', '+2 weeks')->format('Y-m-d'),
            'status' => fake()->randomElement(['Dipinjam', 'Dikembalikan']),
        ];
    }
}
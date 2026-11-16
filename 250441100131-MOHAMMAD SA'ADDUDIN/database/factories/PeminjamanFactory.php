<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;


class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        $tanggalPinjam = fake()->dateTimeBetween('-1 month', '-1 week');

        return [
            'anggota_id' => Anggota::factory(),

            'buku_id' => Buku::factory(),

            'tanggal_pinjam' => $tanggalPinjam,

            // boleh kosong (null) jika buku belum dikembalikan
            'tanggal_kembali' => fake()->optional()->dateTimeBetween($tanggalPinjam, 'now'),
        ];
    }
}

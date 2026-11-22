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

        // boleh kosong (null) jika buku belum dikembalikan
        $tanggalKembali = fake()->optional()->dateTimeBetween($tanggalPinjam, 'now');

        return [
            'anggota_id' => Anggota::factory(),

            'buku_id' => Buku::factory(),

            'tanggal_pinjam' => $tanggalPinjam,

            'tanggal_kembali' => $tanggalKembali,

            // Modul 5: status mengikuti ada/tidaknya tanggal kembali
            'status' => $tanggalKembali ? 'dikembalikan' : 'dipinjam',
        ];
    }
}

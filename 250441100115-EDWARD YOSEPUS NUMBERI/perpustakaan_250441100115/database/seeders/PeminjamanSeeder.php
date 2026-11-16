<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Peminjaman::factory()->count(3)->sequence(
            ['tanggal_pinjam' => '2026-03-01', 'tanggal_kembali' => '2026-03-08'],
            ['tanggal_pinjam' => '2026-03-05', 'tanggal_kembali' => '2026-03-12'],
            ['tanggal_pinjam' => '2026-03-10', 'tanggal_kembali' => null]
        )->create();
    }
}

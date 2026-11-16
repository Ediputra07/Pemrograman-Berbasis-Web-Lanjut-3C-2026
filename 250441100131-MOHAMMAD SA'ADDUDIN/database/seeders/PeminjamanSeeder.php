<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $buku = Buku::all();

        Anggota::all()->each(function ($satuAnggota) use ($buku) {
            Peminjaman::factory()
                ->for($satuAnggota)          
                ->for($buku->random())       
                ->create();
        });
    }
}

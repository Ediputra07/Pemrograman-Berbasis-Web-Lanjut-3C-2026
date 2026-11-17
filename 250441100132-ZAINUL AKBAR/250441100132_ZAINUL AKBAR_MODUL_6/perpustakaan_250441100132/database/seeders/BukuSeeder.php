<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run()
    {
        // Masukkan data buku asli dengan kategori_id
        Buku::create([
            'kategori_id' => 1, // Sesuaikan dengan id kategori yang ada di tabel kategoris
            'judul' => 'Laskar Pelangi',
            'penulis' => 'Andrea Hirata',
            'penerbit' => 'Bentang Pustaka',
            'tahun_terbit' => '2005',
        ]);

        Buku::create([
            'kategori_id' => 1,
            'judul' => 'Bumi Manusia',
            'penulis' => 'Pramoedya Ananta Toer',
            'penerbit' => 'Lentera Dipantara',
            'tahun_terbit' => '1980',
        ]);

        Buku::create([
            'kategori_id' => 2,
            'judul' => 'Filosofi Teras',
            'penulis' => 'Henry Manampiring',
            'penerbit' => 'Kompas',
            'tahun_terbit' => '2018',
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Kategori;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori otomatis dibuat atau dicari ID-nya berdasarkan nama
        $teknologi = Kategori::firstOrCreate(['nama' => 'Teknologi']);
        $komputer = Kategori::firstOrCreate(['nama' => 'Komputer']);
        $database = Kategori::firstOrCreate(['nama' => 'Database']);
        $jaringan = Kategori::firstOrCreate(['nama' => 'Jaringan']);
        $ai = Kategori::firstOrCreate(['nama' => 'Kecerdasan Buatan']);

        $bukuList = [
            [
                'kategori_id' => $teknologi->id,
                'judul'       => 'Pemrograman API Laravel',
                'penulis'     => 'Moh. Umar Faruq',
                'tahun_terbit'=> 2026,
            ],
            [
                'kategori_id' => $komputer->id,
                'judul'       => 'Algoritma dan Struktur Data',
                'penulis'     => 'Rinaldi Munir',
                'tahun_terbit'=> 2021,
            ],
            [
                'kategori_id' => $database->id,
                'judul'       => 'Basis Data Relasional',
                'penulis'     => 'Fathansyah',
                'tahun_terbit'=> 2020,
            ],
            [
                'kategori_id' => $jaringan->id,
                'judul'       => 'Jaringan Komputer Modern',
                'penulis'     => 'Andrew S. Tanenbaum',
                'tahun_terbit'=> 2019,
            ],
            [
                'kategori_id' => $ai->id,
                'judul'       => 'Kecerdasan Buatan dan Pembelajaran Mesin',
                'penulis'     => 'Suyanto',
                'tahun_terbit'=> 2022,
            ],
        ];

        foreach ($bukuList as $data) {
            Buku::create($data);
        }
    }
}

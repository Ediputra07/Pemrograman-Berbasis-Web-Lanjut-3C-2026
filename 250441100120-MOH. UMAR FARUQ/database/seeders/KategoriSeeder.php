<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        // Buat kategori terlebih dahulu jika belum ada
        $kategori1 = Kategori::firstOrCreate(['id' => 1], ['nama' => 'Teknologi']);
        $kategori2 = Kategori::firstOrCreate(['id' => 2], ['nama' => 'Komputer']);
        $kategori3 = Kategori::firstOrCreate(['id' => 3], ['nama' => 'Database']);
        $kategori4 = Kategori::firstOrCreate(['id' => 4], ['nama' => 'Jaringan']);
        $kategori5 = Kategori::firstOrCreate(['id' => 5], ['nama' => 'Kecerdasan Buatan']);

        $bukus = [
            [
                'kategori_id' => $kategori1->id,
                'judul' => 'Pemrograman Web dengan Laravel',
                'penulis' => 'Budi Raharjo',
                'tahun_terbit' => 2023,
            ],
            [
                'kategori_id' => $kategori2->id,
                'judul' => 'Algoritma dan Struktur Data',
                'penulis' => 'Rinaldi Munir',
                'tahun_terbit' => 2021,
            ],
            [
                'kategori_id' => $kategori3->id,
                'judul' => 'Basis Data Relasional',
                'penulis' => 'Fathansyah',
                'tahun_terbit' => 2020,
            ],
            [
                'kategori_id' => $kategori4->id,
                'judul' => 'Jaringan Komputer Modern',
                'penulis' => 'Andrew S. Tanenbaum',
                'tahun_terbit' => 2019,
            ],
            [
                'kategori_id' => $kategori5->id,
                'judul' => 'Kecerdasan Buatan dan Pembelajaran Mesin',
                'penulis' => 'Suyanto',
                'tahun_terbit' => 2022,
            ],
            [
                'kategori_id' => $kategori3->id,
                'judul' => 'Sistem Manajemen Basis Data',
                'penulis' => 'Rosa A. S.',
                'tahun_terbit' => 2021,
            ],
            [
                'kategori_id' => $kategori2->id,
                'judul' => 'Pemrograman Berorientasi Objek',
                'penulis' => 'Munawar',
                'tahun_terbit' => 2020,
            ],
            [
                'kategori_id' => $kategori1->id,
                'judul' => 'Desain Antarmuka Pengguna (UI/UX)',
                'penulis' => 'Andri Kristanto',
                'tahun_terbit' => 2022,
            ],
            [
                'kategori_id' => $kategori4->id,
                'judul' => 'Keamanan Jaringan Komputer',
                'penulis' => 'Iwan Sofana',
                'tahun_terbit' => 2018,
            ],
            [
                'kategori_id' => $kategori5->id,
                'judul' => 'Analisis dan Perancangan Sistem Informasi',
                'penulis' => 'Jogiyanto',
                'tahun_terbit' => 2023,
            ],
        ];

        foreach ($bukus as $buku) {
            Buku::firstOrCreate(
                ['judul' => $buku['judul'], 'penulis' => $buku['penulis']],
                $buku
            );
        }
    }
}

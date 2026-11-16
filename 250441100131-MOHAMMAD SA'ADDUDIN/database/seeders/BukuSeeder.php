<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Kategori::pluck('id', 'nama');

        Buku::factory()
            ->count(5)
            ->sequence(
                [
                    'kategori_id'  => $kategori['Pemrograman'],
                    'judul'        => 'Automate the Boring Stuff with Python',
                    'penulis'      => 'Al Sweigart',
                    'tahun_terbit' => 2015,
                ],
                [
                    'kategori_id'  => $kategori['Rekayasa Perangkat Lunak'],
                    'judul'        => 'Clean Architecture',
                    'penulis'      => 'Robert C. Martin',
                    'tahun_terbit' => 2017,
                ],
                [
                    'kategori_id'  => $kategori['Basis Data'],
                    'judul'        => 'Designing Data-Intensive Applications',
                    'penulis'      => 'Martin Kleppmann',
                    'tahun_terbit' => 2017,
                ],
                [
                    'kategori_id'  => $kategori['Pengembangan Web'],
                    'judul'        => 'Laravel: Up & Running',
                    'penulis'      => 'Matt Stauffer',
                    'tahun_terbit' => 2019,
                ],
                [
                    'kategori_id'  => $kategori['Pemrograman Web'],
                    'judul'        => 'Eloquent JavaScript',
                    'penulis'      => 'Marijn Haverbeke',
                    'tahun_terbit' => 2024,
                ],
            )
            ->create();
    }
}

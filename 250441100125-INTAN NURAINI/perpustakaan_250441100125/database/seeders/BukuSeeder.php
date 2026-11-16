<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $novel = Kategori::where('nama', 'Novel')->value('id');
        $fantasi = Kategori::where('nama', 'Fantasi')->value('id');
        $pengembanganDiri = Kategori::where('nama', 'Pengembangan Diri')->value('id');
        $sejarah = Kategori::where('nama', 'Sejarah')->value('id');
        $romansa = Kategori::where('nama', 'Romansa')->value('id');
        $keuangan = Kategori::where('nama', 'Keuangan')->value('id');

        Buku::factory()
            ->count(10)
            ->state(new Sequence(
                [
                    'kategori_id' => $novel,
                    'judul' => 'Tentang Kamu',
                    'penulis' => 'Tere Liye',
                    'tahun_terbit' => 2016,
                ],
                [
                    'kategori_id' => $fantasi,
                    'judul' => 'Bumi',
                    'penulis' => 'Tere Liye',
                    'tahun_terbit' => 2014,
                ],
                [
                    'kategori_id' => $novel,
                    'judul' => 'Negeri 5 Menara',
                    'penulis' => 'Ahmad Fuadi',
                    'tahun_terbit' => 2009,
                ],
                [
                    'kategori_id' => $pengembanganDiri,
                    'judul' => 'Filosofi Teras',
                    'penulis' => 'Henry Manampiring',
                    'tahun_terbit' => 2018,
                ],
                [
                    'kategori_id' => $novel,
                    'judul' => 'The Devil',
                    'penulis' => 'alreschariys',
                    'tahun_terbit' => 2025,
                ],
                [
                    'kategori_id' => $novel,
                    'judul' => 'Perahu Kertas',
                    'penulis' => 'Dee Lestari',
                    'tahun_terbit' => 2009,
                ],
                [
                    'kategori_id' => $pengembanganDiri,
                    'judul' => 'Atomic Habits',
                    'penulis' => 'James Clear',
                    'tahun_terbit' => 2018,
                ],
                [
                    'kategori_id' => $sejarah,
                    'judul' => 'Bumi Manusia',
                    'penulis' => 'Pramoedya Ananta Toer',
                    'tahun_terbit' => 1980,
                ],
                [
                    'kategori_id' => $romansa,
                    'judul' => 'Dilan 1990',
                    'penulis' => 'Pidi Baiq',
                    'tahun_terbit' => 2014,
                ],
                [
                    'kategori_id' => $keuangan,
                    'judul' => 'The Psychology of Money',
                    'penulis' => 'Morgan Housel',
                    'tahun_terbit' => 2020,
                ],
            ))
            ->create();
    }
}
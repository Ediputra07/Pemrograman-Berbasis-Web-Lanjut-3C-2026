<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tek = Kategori::where('nama', 'Teknologi')->first()?->id ?? 1;
        $nov = Kategori::where('nama', 'Novel')->first()?->id ?? 2;
        $ped = Kategori::where('nama', 'Pendidikan')->first()?->id ?? 3;

        Buku::factory()->count(5)->sequence(
            ['kategori_id' => $tek, 'judul' => 'Pemrograman Web dengan Laravel', 'penulis' => 'Andi Wijaya', 'tahun_terbit' => 2023],
            ['kategori_id' => $tek, 'judul' => 'Struktur Data dan Algoritma', 'penulis' => 'Budi Santoso', 'tahun_terbit' => 2022],
            ['kategori_id' => $tek, 'judul' => 'Dasar-Dasar Basis Data', 'penulis' => 'Citra Lestari', 'tahun_terbit' => 2021],
            ['kategori_id' => $nov, 'judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'tahun_terbit' => 2005],
            ['kategori_id' => $ped, 'judul' => 'Metodologi Penelitian Pendidikan', 'penulis' => 'Prof. Dr. Sugiyono', 'tahun_terbit' => 2020]
        )->create();
    }
}

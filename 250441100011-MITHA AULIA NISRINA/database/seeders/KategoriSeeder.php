<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::factory()->create([
            'nama' => 'Sastra & Fiksi',
        ]);

        Kategori::factory()->create([
            'nama' => 'Pengembangan Diri',
        ]);

        Kategori::factory()->create([
            'nama' => 'Sejarah & Sosial',
        ]);

        Kategori::factory()->create([
            'nama' => 'Pendidikan',
        ]);

        Kategori::factory()->create([
            'nama' => 'Teknologi & Digital',
        ]);

        Kategori::factory()->create([
            'nama' => 'Sains & Pengetahuan',
        ]);
    }
}
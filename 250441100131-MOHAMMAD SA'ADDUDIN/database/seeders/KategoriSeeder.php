<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::factory()
            ->count(5)
            ->sequence(
                ['nama' => 'Pemrograman'],
                ['nama' => 'Rekayasa Perangkat Lunak'],
                ['nama' => 'Basis Data'],
                ['nama' => 'Pengembangan Web'],
                ['nama' => 'Pemrograman Web'],
            )
            ->create();
    }
}

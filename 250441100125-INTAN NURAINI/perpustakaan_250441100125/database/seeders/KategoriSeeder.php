<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::factory()
            ->count(6)
            ->state(new Sequence(
                ['nama' => 'Novel'],
                ['nama' => 'Fantasi'],
                ['nama' => 'Pengembangan Diri'],
                ['nama' => 'Sejarah'],
                ['nama' => 'Romansa'],
                ['nama' => 'Keuangan'],
            ))
            ->create();
    }
}
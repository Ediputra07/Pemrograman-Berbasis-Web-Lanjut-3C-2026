<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::factory()->count(3)->sequence(
            ['nama' => 'Teknologi'],
            ['nama' => 'Novel'],
            ['nama' => 'Pendidikan']
        )->create();
    }
}

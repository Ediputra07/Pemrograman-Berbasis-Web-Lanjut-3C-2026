<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Peminjaman;


class PeminjamanSeeder extends Seeder
{
    


    public function run(): void
    {
        Peminjaman::factory()->count(3)->create();
    }
}

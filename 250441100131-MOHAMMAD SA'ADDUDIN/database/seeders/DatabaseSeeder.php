<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,      // Modul 5: role & permission
            KategoriSeeder::class,
            AnggotaSeeder::class,
            BukuSeeder::class,
            UserSeeder::class,      // Modul 5: akun admin, petugas, siswa (+ profil anggota)
            PeminjamanSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        $admin = User::updateOrCreate(
            ['email' => 'mumarfaruq@gmail.com'],
            [
                'name' => 'Moh. Umar Faruq (Admin)',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->syncRoles(['admin']); // Memastikan role admin selalu disinkronkan

        // 2. Akun Petugas
        $petugas = User::updateOrCreate(
            ['email' => 'petugas@perpustakaan.com'],
            [
                'name' => 'Petugas Perpustakaan',
                'password' => Hash::make('password123'),
            ]
        );
        $petugas->syncRoles(['petugas']);

        // 3. Akun Siswa
        $siswa = User::updateOrCreate(
            ['email' => 'siswa@perpustakaan.com'],
            [
                'name' => 'Siswa Anggota',
                'password' => Hash::make('password123'),
            ]
        );
        $siswa->syncRoles(['siswa']);
    }
}
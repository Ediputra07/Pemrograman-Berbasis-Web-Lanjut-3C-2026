<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Daftar 16 Permission sesuai Modul
        $permissions = [
            'akses dashboard admin',
            'akses dashboard petugas',
            'lihat daftar buku',
            'kelola data buku',
            'kelola data pengguna',
            'kelola role pengguna',
            'kelola peminjaman',
            'kelola pengembalian',
            'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // 2. Buat Role & Hubungkan dengan Permission masing-masing
        
        // ADMIN
        $adminRole = Role::findOrCreate('admin', 'web');
        $adminRole->syncPermissions([
            'akses dashboard admin',
            'lihat daftar buku',
            'kelola data buku',
            'kelola data pengguna',
            'kelola role pengguna',
            'kelola peminjaman',
            'kelola pengembalian',
            'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // PETUGAS
        $petugasRole = Role::findOrCreate('petugas', 'web');
        $petugasRole->syncPermissions([
            'akses dashboard petugas',
            'lihat daftar buku',
            'kelola data buku',
            'kelola peminjaman',
            'kelola pengembalian',
            'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // SISWA
        $siswaRole = Role::findOrCreate('siswa', 'web');
        $siswaRole->syncPermissions([
            'lihat daftar buku',
            'mengajukan peminjaman buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // 3. Akun Testing Default (Gunakan firstOrCreate agar tidak duplikat saat seeder dijalankan ulang)
        $admin = User::firstOrCreate(
            ['email' => 'admin@perpus.com'],
            ['name' => 'Administrator Utama', 'password' => Hash::make('password123')]
        );
        $admin->assignRole($adminRole);

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@perpus.com'],
            ['name' => 'Petugas Perpustakaan', 'password' => Hash::make('password123')]
        );
        $petugas->assignRole($petugasRole);

        $siswa = User::firstOrCreate(
            ['email' => 'siswa@perpus.com'],
            ['name' => 'Siswa Utama', 'password' => Hash::make('password123')]
        );
        $siswa->assignRole($siswaRole);
    }
}
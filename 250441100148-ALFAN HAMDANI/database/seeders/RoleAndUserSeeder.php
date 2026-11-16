<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles dan permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Definisikan Permissions sesuai tabel modul praktikum
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
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 2. Buat Roles dan Sinkronisasi Permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions([
            'akses dashboard admin',
            'lihat daftar buku',
            'kelola data buku',
            'kelola data pengguna',
            'kelola role pengguna',
            'kelola peminjaman',
            'kelola pengembalian',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        $petugasRole = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $petugasRole->syncPermissions([
            'akses dashboard petugas',
            'lihat daftar buku',
            'kelola data buku',
            'kelola peminjaman',
            'kelola pengembalian',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        $siswaRole = Role::firstOrCreate(['name' => 'siswa', 'guard_name' => 'web']);
        $siswaRole->syncPermissions([
            'lihat daftar buku',
            'mengajukan peminjaman buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // 3. Buat Akun Pengguna Default untuk Pengujian
        $admin = User::firstOrCreate(
            ['email' => 'admin@perpus.com'],
            ['name' => 'Administrator', 'password' => Hash::make('admin12345')]
        );
        $admin->assignRole('admin');

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@perpus.com'],
            ['name' => 'Petugas Perpus', 'password' => Hash::make('password')]
        );
        $petugas->assignRole('petugas');

        $siswa = User::firstOrCreate(
            ['email' => 'siswa@perpus.com'],
            ['name' => 'Siswa Teladan', 'password' => Hash::make('password')]
        );
        $siswa->assignRole('siswa');
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Semua Permission Sesuai Tabel Soal 4 Modul 5
        $permissions = [
            'Akses dashboard admin',
            'Akses dashboard petugas',
            'Lihat daftar buku',
            'Kelola data buku',
            'Kelola data pengguna',
            'Kelola role pengguna',
            'Kelola peminjaman',
            'Kelola pengembalian',
            'Mengajukan peminjaman buku',
            'Memproses persetujuan peminjaman',
            'Mencatat pengembalian buku',
            'Melihat status peminjaman sendiri',
            'Melihat riwayat peminjaman sendiri',
            'Lihat laporan perpustakaan',
            'Lihat profil sendiri',
            'Ubah profil sendiri',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Buat Role dan Assign Permission Sesuai Matriks Modul 5
        
        // --- ROLE ADMIN ---
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions([
            'Akses dashboard admin',
            'Lihat daftar buku',
            'Kelola data buku',
            'Kelola data pengguna',
            'Kelola role pengguna',
            'Kelola peminjaman',
            'Kelola pengembalian',
            'Memproses persetujuan peminjaman',
            'Mencatat pengembalian buku',
            'Melihat status peminjaman sendiri',
            'Melihat riwayat peminjaman sendiri',
            'Lihat laporan perpustakaan',
            'Lihat profil sendiri',
            'Ubah profil sendiri',
        ]);

        // --- ROLE PETUGAS ---
        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);
        $petugasRole->syncPermissions([
            'Akses dashboard petugas',
            'Lihat daftar buku',
            'Kelola data buku',
            'Kelola peminjaman',
            'Kelola pengembalian',
            'Mengajukan peminjaman buku',
            'Memproses persetujuan peminjaman',
            'Mencatat pengembalian buku',
            'Melihat status peminjaman sendiri',
            'Melihat riwayat peminjaman sendiri',
            'Lihat laporan perpustakaan',
            'Lihat profil sendiri',
            'Ubah profil sendiri',
        ]);

        // --- ROLE SISWA ---
        $siswaRole = Role::firstOrCreate(['name' => 'siswa']);
        $siswaRole->syncPermissions([
            'Lihat daftar buku',
            'Melihat status peminjaman sendiri',
            'Melihat riwayat peminjaman sendiri',
            'Lihat profil sendiri',
            'Ubah profil sendiri',
        ]);
    }
}
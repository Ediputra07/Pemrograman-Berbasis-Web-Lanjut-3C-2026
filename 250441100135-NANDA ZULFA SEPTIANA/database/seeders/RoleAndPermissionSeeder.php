<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset cached roles and permissions Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Buat semua permissions satu per satu secara aman menggunakan firstOrCreate
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
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 3. Buat Roles
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $rolePetugas = Role::firstOrCreate(['name' => 'petugas']);
        $roleSiswa = Role::firstOrCreate(['name' => 'siswa']);

        // 4. Berikan Permissions ke masing-masing Role
        $roleAdmin->syncPermissions([
            'akses dashboard admin', 'lihat daftar buku', 'kelola data buku',
            'kelola data pengguna', 'kelola role pengguna', 'kelola peminjaman',
            'kelola pengembalian', 'memproses persetujuan peminjaman',
            'mencatat pengembalian buku', 'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri', 'lihat laporan perpustakaan',
            'lihat profil sendiri', 'ubah profil sendiri'
        ]);

        $rolePetugas->syncPermissions([
            'akses dashboard petugas', 'lihat daftar buku', 'kelola data buku',
            'kelola peminjaman', 'kelola pengembalian', 'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman', 'mencatat pengembalian buku',
            'melihat status peminjaman sendiri', 'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan', 'lihat profil sendiri', 'ubah profil sendiri'
        ]);

        $roleSiswa->syncPermissions([
            'lihat daftar buku', 'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri', 'lihat profil sendiri', 'ubah profil sendiri'
        ]);

        // 5. Buat Akun Pengguna Default
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($roleAdmin);

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Petugas Perpustakaan',
                'password' => Hash::make('password123'),
            ]
        );
        $petugas->assignRole($rolePetugas);

        $siswa = User::firstOrCreate(
            ['email' => 'siswa@gmail.com'],
            [
                'name' => 'Siswa Perpustakaan',
                'password' => Hash::make('password123'),
            ]
        );
        $siswa->assignRole($roleSiswa); 
    }
}
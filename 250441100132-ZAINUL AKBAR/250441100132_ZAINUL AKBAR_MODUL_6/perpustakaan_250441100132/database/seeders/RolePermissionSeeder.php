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
        // 1. Daftar 16 Permission sesuai Modul 5
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

        // Memasukkan permission ke database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Membuat Role (Admin, Petugas, Siswa)
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $rolePetugas = Role::firstOrCreate(['name' => 'petugas']);
        $roleSiswa = Role::firstOrCreate(['name' => 'siswa']);

        // 3. Menetapkan Permission ke masing-masing Role sesuai tabel Modul 5
        
        // -- Role Admin --
        $roleAdmin->givePermissionTo([
            'Akses dashboard admin', 'Lihat daftar buku', 'Kelola data buku', 
            'Kelola data pengguna', 'Kelola role pengguna', 'Kelola peminjaman', 
            'Kelola pengembalian', 'Memproses persetujuan peminjaman', 'Mencatat pengembalian buku', 
            'Melihat status peminjaman sendiri', 'Melihat riwayat peminjaman sendiri', 
            'Lihat laporan perpustakaan', 'Lihat profil sendiri', 'Ubah profil sendiri'
        ]);

        // -- Role Petugas --
        $rolePetugas->givePermissionTo([
            'Akses dashboard petugas', 'Lihat daftar buku', 'Kelola data buku', 
            'Kelola peminjaman', 'Kelola pengembalian', 'Mengajukan peminjaman buku', 
            'Memproses persetujuan peminjaman', 'Mencatat pengembalian buku', 
            'Melihat status peminjaman sendiri', 'Melihat riwayat peminjaman sendiri', 
            'Lihat laporan perpustakaan', 'Lihat profil sendiri', 'Ubah profil sendiri'
        ]);

        // -- Role Siswa --
        $roleSiswa->givePermissionTo([
            'Lihat daftar buku', 'Melihat status peminjaman sendiri', 
            'Melihat riwayat peminjaman sendiri', 'Lihat profil sendiri', 'Ubah profil sendiri'
        ]);

        // 4. Membuat / Memperbarui Akun Dummy (Password Admin diganti menjadi kuat untuk Soal 5c)
        $admin = User::updateOrCreate([
            'email' => 'admin@perpus.com'
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('admin');

        $petugas = User::firstOrCreate([
            'email' => 'petugas@perpus.com'
        ], [
            'name' => 'Petugas Perpus',
            'password' => Hash::make('password123')
        ]);
        $petugas->assignRole('petugas');

        $siswa = User::firstOrCreate([
            'email' => 'siswa@perpus.com'
        ], [
            'name' => 'Siswa Aktif',
            'password' => Hash::make('password123')
        ]);
        $siswa->assignRole('siswa');
    }
}
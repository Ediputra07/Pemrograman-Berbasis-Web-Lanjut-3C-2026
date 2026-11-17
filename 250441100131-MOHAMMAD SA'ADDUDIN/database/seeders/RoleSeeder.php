<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    private const PERMISSION = [
        'akses dashboard admin'                 => [true,  false, false], 
        'akses dashboard petugas'               => [false, true,  false], 
        'lihat daftar buku'                     => [true,  true,  true],  
        'kelola data buku'                      => [true,  true,  false], 
        'kelola data pengguna'                  => [true,  false, false], 
        'kelola role pengguna'                  => [true,  false, false], 
        'kelola peminjaman'                     => [true,  true,  false], 
        'kelola pengembalian'                   => [true,  true,  false], 
        'mengajukan peminjaman buku'            => [true,  true,  true],  
        'memproses persetujuan peminjaman'      => [true,  true,  false], 
        'mencatat pengembalian buku'            => [true,  true,  false], 
        'melihat status peminjaman sendiri'     => [true,  true,  true],  
        'melihat riwayat peminjaman sendiri'    => [true,  true,  true],  
        'lihat laporan perpustakaan'            => [true,  true,  false], 
        'lihat profil sendiri'                  => [true,  true,  true],  
        'ubah profil sendiri'                   => [true,  true,  true],  
    ];

    public function run(): void
    {
        // Kosongkan cache permission agar data baru langsung terbaca
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $admin   = Role::firstOrCreate(['name' => 'admin',   'guard_name' => 'web']);
        $petugas = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $siswa   = Role::firstOrCreate(['name' => 'siswa',   'guard_name' => 'web']);

        $milik = ['admin' => [], 'petugas' => [], 'siswa' => []];

        foreach (self::PERMISSION as $nama => [$bagiAdmin, $bagiPetugas, $bagiSiswa]) {
            Permission::firstOrCreate(['name' => $nama, 'guard_name' => 'web']);

            if ($bagiAdmin)   { $milik['admin'][]   = $nama; }
            if ($bagiPetugas) { $milik['petugas'][] = $nama; }
            if ($bagiSiswa)   { $milik['siswa'][]   = $nama; }
        }

        // syncPermissions: hasil akhir persis sama dengan daftar (aman dijalankan berulang)
        $admin->syncPermissions($milik['admin']);
        $petugas->syncPermissions($milik['petugas']);
        $siswa->syncPermissions($milik['siswa']);
    }
}

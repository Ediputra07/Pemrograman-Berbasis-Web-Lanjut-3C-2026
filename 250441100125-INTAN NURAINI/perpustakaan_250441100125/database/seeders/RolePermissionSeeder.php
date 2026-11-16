<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan cache permission Spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar permission
        $permissions = [
            'admin dashboard',
            'petugas dashboard',
            'view book list',
            'manage books',
            'manage users',
            'manage user roles',
            'manage borrowings',
            'manage returns',
            'request borrowing',
            'process borrowing approval',
            'record return',
            'view own borrowing status',
            'view own borrowing history',
            'view library reports',
            'view own profile',
            'update own profile',
        ];

        // Buat permission jika belum ada
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Buat role jika belum ada
        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $petugas = Role::firstOrCreate([
            'name' => 'Petugas',
            'guard_name' => 'web',
        ]);

        $siswa = Role::firstOrCreate([
            'name' => 'Siswa',
            'guard_name' => 'web',
        ]);

        // Admin: seluruh permission
        $admin->syncPermissions($permissions);

        // Petugas: mengelola operasional perpustakaan
        $petugas->syncPermissions([
            'petugas dashboard',
            'view book list',
            'manage books',
            'manage borrowings',
            'manage returns',
            'process borrowing approval',
            'record return',
            'view library reports',
            'view own profile',
            'update own profile',
        ]);

        // Siswa: mengakses fitur miliknya sendiri
        $siswa->syncPermissions([
            'view book list',
            'request borrowing',
            'view own borrowing status',
            'view own borrowing history',
            'view own profile',
            'update own profile',
        ]);

        // Bersihkan cache kembali
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}

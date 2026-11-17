<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PermissionMatrixTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_role_permissions_match_the_feature_matrix(): void
    {
        $adminPermissions = [
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
        $petugasPermissions = array_values(array_diff($adminPermissions, [
            'akses dashboard admin',
            'kelola data pengguna',
            'kelola role pengguna',
        ]));
        $siswaPermissions = [
            'lihat daftar buku',
            'mengajukan peminjaman buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ];

        foreach ([
            'admin' => $adminPermissions,
            'petugas' => $petugasPermissions,
            'siswa' => $siswaPermissions,
        ] as $roleName => $expectedPermissions) {
            $role = Role::findByName($roleName, 'web');

            $this->assertEqualsCanonicalizing(
                $expectedPermissions,
                $role->permissions->pluck('name')->all(),
                "The {$roleName} role does not match the feature matrix.",
            );
        }
    }

    public function test_admin_and_petugas_have_their_allowed_pages(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->get(route('users.index'))
            ->assertOk()
            ->assertSee('Kelola Data Pengguna');
        $this->get(route('users.roles.index'))->assertOk();
        $this->get(route('laporan.index'))->assertOk();
        $this->get(route('dashboard'))->assertOk()->assertSee('Dashboard Admin');

        $staff = User::factory()->create();
        $staff->assignRole('petugas');

        $this->actingAs($staff)
            ->get(route('users.index'))
            ->assertForbidden();
        $this->get(route('users.roles.index'))->assertForbidden();
        $this->get(route('laporan.index'))->assertOk();
        $this->get(route('pengembalian.index'))->assertOk();
        $this->get(route('dashboard'))->assertOk()->assertSee('Dashboard Petugas');
    }

    public function test_admin_can_change_a_user_role_and_siswa_cannot_open_staff_pages(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $target = User::factory()->create();
        $target->assignRole('siswa');

        $this->actingAs($admin)
            ->patch(route('users.roles.update', $target), ['role' => 'petugas'])
            ->assertRedirect(route('users.roles.index'));

        $this->assertTrue($target->fresh()->hasRole('petugas'));

        $student = User::factory()->create();
        $student->assignRole('siswa');

        $this->actingAs($student)
            ->get(route('buku.katalog'))
            ->assertOk();
        $this->get(route('peminjaman.status'))->assertOk();
        $this->get(route('peminjaman.index'))->assertOk();
        $this->get(route('profile.edit'))->assertOk();
        $this->get(route('users.index'))->assertForbidden();
        $this->get(route('pengembalian.index'))->assertForbidden();
        $this->get(route('laporan.index'))->assertForbidden();
    }
}

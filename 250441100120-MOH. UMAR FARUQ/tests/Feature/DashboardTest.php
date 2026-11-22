<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_admin_dashboard_shows_library_summary_and_recent_loans(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $member = Anggota::factory()->create(['nama' => 'Anggota Dashboard']);
        $book = Buku::factory()->create(['judul' => 'Buku Dashboard']);

        Peminjaman::factory()->create([
            'anggota_id' => $member->id,
            'buku_id' => $book->id,
            'status' => 'Pending',
        ]);
        Peminjaman::factory()->create([
            'anggota_id' => $member->id,
            'buku_id' => $book->id,
            'status' => 'Dipinjam',
        ]);

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Admin')
            ->assertSee('Koleksi Buku')
            ->assertSee('Menunggu Persetujuan')
            ->assertSee('Sedang Dipinjam')
            ->assertSee('Kelola Peminjaman')
            ->assertSee('Anggota Dashboard')
            ->assertSee('Buku Dashboard');
    }

    public function test_student_dashboard_shows_only_student_features(): void
    {
        $student = User::factory()->create();
        $student->assignRole('siswa');

        $this->actingAs($student)
            ->get(route('dashboard'))
            ->assertRedirect(route('buku.katalog'));
    }

    public function test_dashboard_rejects_users_without_a_supported_role(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertForbidden();
    }
}

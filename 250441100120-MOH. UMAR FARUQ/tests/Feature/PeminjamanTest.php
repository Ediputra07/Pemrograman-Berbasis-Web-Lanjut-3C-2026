<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\RolePermissionSeeder;
use Tests\TestCase;

class PeminjamanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_student_can_request_a_loan_using_their_member_record(): void
    {
        $student = User::factory()->create();
        $student->assignRole('siswa');
        $member = Anggota::factory()->create(['email' => $student->email]);
        $book = Buku::factory()->create();

        $this->actingAs($student)
            ->post(route('peminjaman.store'), ['buku_id' => $book->id])
            ->assertRedirect(route('buku.katalog'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('peminjamans', [
            'anggota_id' => $member->id,
            'buku_id' => $book->id,
            'status' => 'Pending',
        ]);
    }

    public function test_student_without_a_member_record_can_request_a_loan(): void
    {
        $student = User::factory()->create();
        $student->assignRole('siswa');
        $book = Buku::factory()->create();

        $this->actingAs($student)
            ->post(route('peminjaman.store'), ['buku_id' => $book->id])
            ->assertRedirect(route('buku.katalog'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('peminjamans', [
            'anggota_id' => 1,
            'buku_id' => $book->id,
            'status' => 'Pending',
        ]);
    }

    public function test_student_sees_only_loans_linked_to_their_email(): void
    {
        $student = User::factory()->create();
        $student->assignRole('siswa');

        $studentMember = Anggota::factory()->create(['email' => $student->email]);
        $studentBook = Buku::factory()->create(['judul' => 'Buku milik siswa']);
        Peminjaman::factory()->create([
            'anggota_id' => $studentMember->id,
            'buku_id' => $studentBook->id,
        ]);

        $otherMember = Anggota::factory()->create();
        $otherBook = Buku::factory()->create(['judul' => 'Buku milik anggota lain']);
        Peminjaman::factory()->create([
            'anggota_id' => $otherMember->id,
            'buku_id' => $otherBook->id,
        ]);

        $this->actingAs($student)
            ->get(route('peminjaman.index'))
            ->assertOk()
            ->assertSee($studentBook->judul)
            ->assertDontSee($otherBook->judul);
    }

    public function test_staff_can_view_and_approve_a_loan(): void
    {
        $staff = User::factory()->create();
        $staff->assignRole('admin');

        $member = Anggota::factory()->create();
        $loan = Peminjaman::factory()->create([
            'anggota_id' => $member->id,
            'buku_id' => Buku::factory()->create()->id,
        ]);

        $this->actingAs($staff)
            ->get(route('peminjaman.kelola'))
            ->assertOk()
            ->assertSee($member->nama);

        $this->put(route('peminjaman.setujui', $loan->id))
            ->assertRedirect();

        $this->assertDatabaseHas('peminjamans', [
            'id' => $loan->id,
            'status' => 'Dipinjam',
        ]);
    }

    public function test_staff_can_record_a_book_return(): void
    {
        $staff = User::factory()->create();
        $staff->assignRole('petugas');
        $loan = Peminjaman::factory()->create([
            'buku_id' => Buku::factory()->create()->id,
            'status' => 'Dipinjam',
        ]);

        $this->actingAs($staff)
            ->get(route('pengembalian.index'))
            ->assertOk();

        $this->put(route('pengembalian.update', $loan))
            ->assertRedirect(route('pengembalian.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('peminjamans', [
            'id' => $loan->id,
            'status' => 'Dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);
    }
}

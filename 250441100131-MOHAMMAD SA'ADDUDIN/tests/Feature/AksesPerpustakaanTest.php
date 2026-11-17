<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Pengujian otomatis untuk skenario pada soal praktikum Modul 5
 * (autentikasi, middleware auth/guest, RBAC Spatie, kepemilikan data).
 *
 * Jalankan: php artisan test --filter=AksesPerpustakaanTest
 */
class AksesPerpustakaanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();               // manifest Vite tidak dibutuhkan saat tes
        $this->seed(DatabaseSeeder::class); // role, permission, akun contoh, data buku
    }

    private function akun(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    private function dataBuku(array $timpa = []): array
    {
        return array_merge([
            'kategori_id'  => Kategori::firstOrFail()->id,
            'judul'        => 'Buku Uji Modul Lima',
            'penulis'      => 'Penulis Uji',
            'tahun_terbit' => 2020,
        ], $timpa);
    }

    /* ------------------------------------------------------------------ */
    /* Autentikasi (soal 1 & 2)                                            */
    /* ------------------------------------------------------------------ */

    public function test_registrasi_membuat_akun_siswa_dan_kata_sandi_di_hash(): void
    {
        $respons = $this->post('/register', [
            'name'                  => 'Mahasiswa Baru',
            'email'                 => 'baru@gmail.com',
            'no_telepon'            => '081234567890',
            'password'              => 'rahasia1234',
            'password_confirmation' => 'rahasia1234',
            'role'                  => 'admin', // upaya memilih role sendiri harus diabaikan
        ]);

        $respons->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $user = $this->akun('baru@gmail.com');
        $this->assertTrue($user->hasRole('siswa'));
        $this->assertFalse($user->hasRole('admin'));
        $this->assertNotSame('rahasia1234', $user->password);
        $this->assertTrue(Hash::check('rahasia1234', $user->password));
        $this->assertSame('081234567890', $user->anggota->no_telepon);
    }

    public function test_login_valid_berhasil_dan_login_tidak_valid_ditolak(): void
    {
        $this->post('/login', ['email' => 'admin@gmail.com', 'password' => 'salah'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post('/login', ['email' => 'admin@gmail.com', 'password' => 'password'])
            ->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }

    public function test_logout_lalu_halaman_terlindungi_meminta_login_kembali(): void
    {
        $this->actingAs($this->akun('admin@gmail.com'));

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->get('/dashboard')->assertRedirect(route('login'));
    }

    public function test_middleware_guest_mengalihkan_pengguna_yang_sudah_login(): void
    {
        $this->actingAs($this->akun('siswa@gmail.com'));

        $this->get('/login')->assertRedirect(route('dashboard'));
        $this->get('/register')->assertRedirect(route('dashboard'));
    }

    public function test_middleware_auth_mengalihkan_pengguna_belum_login(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
        $this->get('/buku')->assertRedirect(route('login'));
        $this->getJson('/api/buku')->assertUnauthorized();
    }

    /* ------------------------------------------------------------------ */
    /* Admin (skenario 2-5)                                                */
    /* ------------------------------------------------------------------ */

    public function test_admin_dapat_membuka_dashboard_dan_halaman_administrasi(): void
    {
        $this->actingAs($this->akun('admin@gmail.com'));

        $this->get(route('admin.dashboard'))->assertOk();
        $this->get(route('admin.pengguna.index'))->assertOk();
        $this->get(route('kelola.peminjaman.index'))->assertOk();
        $this->get(route('kelola.pengembalian.index'))->assertOk();
        $this->get(route('laporan.index'))
            ->assertOk()
            ->assertSee('Cetak Laporan')
            ->assertSee('Rekapitulasi Peminjaman Buku');
        $this->getJson('/api/rekap/buku-per-kategori')->assertOk();
    }

    public function test_judul_buku_di_escaping_dan_pencarian_tidak_menggabungkan_sql(): void
    {
        $buku = Buku::firstOrFail();
        $judulBerbahaya = "<script>alert('uji')</script>";
        $buku->update(['judul' => $judulBerbahaya]);

        $this->actingAs($this->akun('siswa@gmail.com'));

        $this->get(route('buku.index'))
            ->assertOk()
            ->assertSee($judulBerbahaya);

        $this->getJson(route('buku.cari', ['judul' => "' OR '1'='1"]))
            ->assertOk()
            ->assertExactJson([]);
    }

    public function test_penghapusan_buku_hanya_menggunakan_delete_dan_memerlukan_izin_kelola(): void
    {
        $buku = Buku::firstOrFail();

        $this->actingAs($this->akun('siswa@gmail.com'));
        $this->delete(route('buku.destroy', $buku))->assertForbidden();
        $this->assertDatabaseHas('bukus', ['id' => $buku->id]);

        $this->actingAs($this->akun('admin@gmail.com'));
        $this->get('/buku/'.$buku->id.'/hapus')->assertNotFound();
        $this->delete(route('buku.destroy', $buku))->assertRedirect(route('buku.index'));
        $this->assertDatabaseMissing('bukus', ['id' => $buku->id]);
    }

    public function test_admin_dapat_menambah_mengubah_dan_menghapus_buku(): void
    {
        $this->actingAs($this->akun('admin@gmail.com'));

        $id = $this->postJson('/api/buku', $this->dataBuku())
            ->assertCreated()
            ->json('data.id');

        $this->putJson("/api/buku/{$id}", ['judul' => 'Judul Diperbarui'])->assertOk();
        $this->assertDatabaseHas('bukus', ['id' => $id, 'judul' => 'Judul Diperbarui']);

        $this->deleteJson("/api/buku/{$id}")->assertOk();
        $this->assertDatabaseMissing('bukus', ['id' => $id]);
    }

    public function test_admin_dapat_mengelola_akun_dan_role_pengguna(): void
    {
        $this->actingAs($this->akun('admin@gmail.com'));

        $this->post(route('admin.pengguna.store'), [
            'name'                  => 'Petugas Baru',
            'email'                 => 'petugasbaru@gmail.com',
            'no_telepon'            => '081200001111',
            'password'              => 'rahasia1234',
            'password_confirmation' => 'rahasia1234',
            'role'                  => 'petugas',
        ])->assertRedirect(route('admin.pengguna.index'));

        $baru = $this->akun('petugasbaru@gmail.com');
        $this->assertTrue($baru->hasRole('petugas'));

        $this->patch(route('admin.pengguna.role', $baru), ['role' => 'siswa'])->assertRedirect();
        $this->assertTrue($baru->fresh()->hasRole('siswa'));
        $this->assertFalse($baru->fresh()->hasRole('petugas'));
    }

    public function test_admin_tidak_dapat_mengubah_role_atau_menghapus_akun_sendiri(): void
    {
        $admin = $this->akun('admin@gmail.com');
        $this->actingAs($admin);

        $this->patch(route('admin.pengguna.role', $admin), ['role' => 'siswa']);
        $this->assertTrue($admin->fresh()->hasRole('admin'));

        $this->delete(route('admin.pengguna.destroy', $admin));
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    /* ------------------------------------------------------------------ */
    /* Petugas (skenario 6-9)                                              */
    /* ------------------------------------------------------------------ */

    public function test_petugas_dapat_membuka_dashboard_dan_mengelola_buku(): void
    {
        $this->actingAs($this->akun('petugas@gmail.com'));

        $this->get(route('petugas.dashboard'))->assertOk();
        $this->postJson('/api/buku', $this->dataBuku())->assertCreated();
        $this->get(route('laporan.index'))
            ->assertOk()
            ->assertSee('Cetak Laporan')
            ->assertSee('Rekapitulasi Peminjaman Buku');
    }

    public function test_petugas_dapat_memproses_peminjaman_dan_pengembalian(): void
    {
        $this->actingAs($this->akun('petugas@gmail.com'));

        $pengajuan = Peminjaman::where('status', Peminjaman::DIAJUKAN)->firstOrFail();

        $this->post(route('kelola.peminjaman.setujui', $pengajuan))->assertRedirect();
        $this->assertSame(Peminjaman::DIPINJAM, $pengajuan->fresh()->status);

        $this->post(route('kelola.pengembalian.catat', $pengajuan))->assertRedirect();
        $this->assertSame(Peminjaman::DIKEMBALIKAN, $pengajuan->fresh()->status);
        $this->assertNotNull($pengajuan->fresh()->tanggal_kembali);
    }

    public function test_petugas_ditolak_di_halaman_akun_role_dan_dashboard_admin(): void
    {
        $petugas = $this->akun('petugas@gmail.com');
        $this->actingAs($petugas);

        $this->get(route('admin.pengguna.index'))->assertForbidden();
        $this->get(route('admin.pengguna.create'))->assertForbidden();
        $this->patch(route('admin.pengguna.role', $petugas), ['role' => 'admin'])->assertForbidden();
        $this->get(route('admin.dashboard'))->assertForbidden();
        $this->assertFalse($petugas->fresh()->hasRole('admin'));
    }

    /* ------------------------------------------------------------------ */
    /* Siswa (skenario 10-14)                                              */
    /* ------------------------------------------------------------------ */

    public function test_siswa_dapat_melihat_daftar_dan_detail_buku(): void
    {
        $this->actingAs($this->akun('siswa@gmail.com'));

        $this->get(route('buku.index'))->assertOk();
        $this->getJson('/api/buku')->assertOk();
        $this->get(route('buku.show', ['id' => Buku::firstOrFail()->id]))->assertOk();
    }

    public function test_siswa_dapat_melihat_dan_memperbarui_profil_sendiri(): void
    {
        $siswa = $this->akun('siswa@gmail.com');
        $this->actingAs($siswa);

        $this->get(route('profile.edit'))->assertOk();

        $this->patch(route('profile.update'), [
            'name'       => 'Siswa Diperbarui',
            'email'      => 'siswa@gmail.com',
            'no_telepon' => '081299998888',
        ])->assertRedirect(route('profile.edit'));

        $this->assertSame('Siswa Diperbarui', $siswa->fresh()->name);
        $this->assertSame('081299998888', $siswa->fresh()->anggota->no_telepon);
    }

    public function test_siswa_dapat_melihat_riwayat_milik_sendiri(): void
    {
        $siswa = $this->akun('siswa@gmail.com');
        $this->actingAs($siswa);

        $this->get(route('peminjaman.riwayat'))
            ->assertRedirect(route('anggota.riwayat', $siswa->anggota));

        $this->get(route('anggota.riwayat', $siswa->anggota))->assertOk();
        $this->get(route('peminjaman.status'))->assertOk();
    }

    public function test_siswa_ditolak_membuka_dashboard_admin_pengelolaan_buku_dan_laporan(): void
    {
        $this->actingAs($this->akun('siswa@gmail.com'));

        $this->get(route('admin.dashboard'))->assertForbidden();
        $this->get(route('petugas.dashboard'))->assertForbidden();
        $this->get(route('admin.pengguna.index'))->assertForbidden();
        $this->get(route('kelola.peminjaman.index'))->assertForbidden();
        $this->get(route('laporan.index'))->assertForbidden();
        $this->getJson('/api/rekap/buku-per-kategori')->assertForbidden();

        // Mengelola buku lewat URL/API langsung juga ditolak
        $this->postJson('/api/buku', $this->dataBuku())->assertForbidden();
        $this->putJson('/api/buku/'.Buku::firstOrFail()->id, ['judul' => 'Dibajak'])->assertForbidden();
        $this->deleteJson('/api/buku/'.Buku::firstOrFail()->id)->assertForbidden();
    }

    public function test_siswa_ditolak_melihat_riwayat_peminjaman_siswa_lain(): void
    {
        $siswa = $this->akun('siswa@gmail.com');
        $this->actingAs($siswa);

        $lain = Anggota::where('id', '!=', $siswa->anggota->id)->firstOrFail();

        $this->get(route('anggota.riwayat', $lain))->assertForbidden();
    }

    public function test_siswa_hanya_dapat_melihat_detail_peminjaman_miliknya(): void
    {
        $siswa = $this->akun('siswa@gmail.com');
        $anggotaLain = Anggota::where('id', '!=', $siswa->anggota->id)->firstOrFail();
        $peminjamanMilikLain = Peminjaman::where('anggota_id', $anggotaLain->id)->firstOrFail();

        $this->actingAs($siswa);
        $this->get(route('peminjaman.show', $peminjamanMilikLain))->assertForbidden();

        $peminjamanMilikSiswa = Peminjaman::where('anggota_id', $siswa->anggota->id)->firstOrFail();
        $this->get(route('peminjaman.show', $peminjamanMilikSiswa))->assertOk();
    }

    public function test_admin_dan_petugas_boleh_melihat_riwayat_anggota_lain(): void
    {
        $siswa = $this->akun('siswa@gmail.com');

        $this->actingAs($this->akun('petugas@gmail.com'))
            ->get(route('anggota.riwayat', $siswa->anggota))
            ->assertOk();
    }

    public function test_siswa_dapat_mengajukan_peminjaman_tetapi_tidak_ganda(): void
    {
        $siswa = $this->akun('siswa@gmail.com');
        $this->actingAs($siswa);

        $buku = Buku::factory()->create(['kategori_id' => Kategori::firstOrFail()->id]);

        $this->post(route('peminjaman.store'), ['buku_id' => $buku->id])
            ->assertRedirect(route('peminjaman.status'));

        $this->assertDatabaseHas('peminjamans', [
            'anggota_id' => $siswa->anggota->id,
            'buku_id'    => $buku->id,
            'status'     => Peminjaman::DIAJUKAN,
        ]);

        // pengajuan kedua untuk buku yang sama ditolak
        $this->post(route('peminjaman.store'), ['buku_id' => $buku->id])
            ->assertSessionHas('error');
        $this->assertSame(1, Peminjaman::where('buku_id', $buku->id)->count());
    }

    public function test_siswa_tidak_dapat_menyetujui_peminjaman(): void
    {
        $this->actingAs($this->akun('siswa@gmail.com'));

        $pengajuan = Peminjaman::where('status', Peminjaman::DIAJUKAN)->firstOrFail();

        $this->post(route('kelola.peminjaman.setujui', $pengajuan))->assertForbidden();
        $this->assertSame(Peminjaman::DIAJUKAN, $pengajuan->fresh()->status);
    }
}

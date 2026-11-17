<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Menampilkan riwayat peminjaman untuk siswa/anggota yang sedang login
    public function index(): View
    {
        $peminjaman = $this->loansForCurrentUser()->get();

        return view('peminjaman.index', [
            'peminjaman' => $peminjaman,
            'title' => 'Riwayat Peminjaman Saya',
        ]);
    }

    public function status(): View
    {
        $peminjaman = $this->loansForCurrentUser()
            ->whereIn('status', ['Pending', 'Diajukan', 'Dipinjam'])
            ->get();

        return view('peminjaman.index', [
            'peminjaman' => $peminjaman,
            'title' => 'Status Peminjaman Saya',
        ]);
    }

    // Siswa mengajukan peminjaman buku
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
        ]);

        $anggota = Anggota::firstOrCreate(
            ['email' => Auth::user()->email],
            ['nama' => Auth::user()->name, 'no_telepon' => null],
        );

        Peminjaman::create([
            'anggota_id'     => $anggota->id,
            'buku_id'        => $request->buku_id,
            'tanggal_pinjam' => now(),
            'status'         => 'Pending',
        ]);

        return redirect()->route('buku.katalog')->with('success', 'Permohonan peminjaman berhasil dikirim. Menunggu persetujuan petugas.');
    }

    // Admin/Petugas melihat daftar kelola peminjaman dengan filter status
    public function kelola(Request $request): View
    {
        $status = $request->query('status');

        $query = Peminjaman::with(['anggota', 'buku']);

        if ($status && $status !== 'Semua') {
            $query->where('status', $status);
        }

        $peminjamanList = $query->latest()->get();

        return view('peminjaman.kelola', [
            'peminjamanList' => $peminjamanList,
            'status' => $status,
        ]);
    }

    // Admin/Petugas menyetujui peminjaman
    public function setujui(int $id): RedirectResponse
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (!in_array($peminjaman->status, ['Pending', 'Diajukan'], true)) {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $peminjaman->update([
            'status' => 'Dipinjam',
            'tanggal_pinjam' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Peminjaman buku berhasil disetujui.');
    }

    // Admin/Petugas menolak peminjaman
    public function tolak(int $id): RedirectResponse
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (!in_array($peminjaman->status, ['Pending', 'Diajukan'], true)) {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $peminjaman->update(['status' => 'Ditolak']);

        return redirect()->back()->with('success', 'Peminjaman buku ditolak.');
    }

    /**
     * @return Builder<Peminjaman>
     */
    private function loansForCurrentUser(): Builder
    {
        return Peminjaman::with('buku')
            ->whereHas('anggota', function ($query): void {
                $query->where('email', Auth::user()->email);
            })
            ->latest();
    }
}
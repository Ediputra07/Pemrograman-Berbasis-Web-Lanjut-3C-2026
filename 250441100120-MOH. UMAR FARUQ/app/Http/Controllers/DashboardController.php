<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasRole('siswa') && $user->can('lihat daftar buku')) {
            return redirect()->route('buku.katalog');
        }

        if (!$user->hasAnyRole(['admin', 'petugas'])
            || (!$user->can('akses dashboard admin') && !$user->can('akses dashboard petugas'))) {
            abort(403, 'Akses ditolak.');
        }

        $isAdmin = $user->can('akses dashboard admin');
        $isStaff = true;
        $latestLoans = collect();

        $stats = [
            'books' => Buku::count(),
            'members' => Anggota::count(),
            'pendingLoans' => Peminjaman::whereIn('status', ['Pending', 'Diajukan'])->count(),
            'activeLoans' => Peminjaman::where('status', 'Dipinjam')->count(),
        ];

        $latestLoans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('isAdmin', 'isStaff', 'latestLoans', 'stats'));
    }
}
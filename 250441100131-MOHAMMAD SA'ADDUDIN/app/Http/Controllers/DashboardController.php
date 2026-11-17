<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Pintu masuk setelah login. Admin dan Petugas diarahkan ke dashboard masing-masing,
     * selain itu (Siswa) menampilkan ringkasan peminjaman miliknya sendiri.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        $aktif = $user->peminjamanSaya()->aktif()->with('buku')->latest('id')->get();
        $totalRiwayat = $user->peminjamanSaya()->count();

        return view('dashboard', compact('aktif', 'totalRiwayat'));
    }
}

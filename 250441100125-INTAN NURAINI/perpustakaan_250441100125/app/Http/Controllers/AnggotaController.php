<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    // Menampilkan daftar anggota
    public function index()
    {
        $anggota = User::with('roles')
            ->latest()
            ->get();

        return view('anggota.index', compact('anggota'));
    }

    // Menambahkan anggota baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['Petugas', 'Siswa'])],
        ]);

        $anggota = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $anggota->assignRole($validated['role']);

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    // Mengubah data anggota
    public function update(Request $request, User $anggota)
    {
        if ($anggota->id == Auth::id()) {
            return back()->with(
                'error',
                'Tidak dapat mengubah role akun sendiri.'
            );
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($anggota->id),
            ],
            'role' => ['required', Rule::in(['Petugas', 'Siswa'])],
        ]);

        $anggota->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $anggota->syncRoles([$validated['role']]);

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    // Menghapus anggota
    public function destroy(User $anggota)
    {
        if ($anggota->id == Auth::id()) {
            return back()->with(
                'error',
                'Tidak dapat menghapus akun sendiri.'
            );
        }

        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}

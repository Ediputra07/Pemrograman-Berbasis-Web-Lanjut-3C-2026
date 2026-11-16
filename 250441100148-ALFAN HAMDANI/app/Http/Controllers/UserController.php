<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil user beserta relasi roles dari Spatie
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,petugas,siswa', // Validasi pilihan role
        ]);

        $user = User::findOrFail($id);

        // 1. Update nama dan email saja
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // 2. Gunakan fungsi Spatie untuk menyinkronkan role ke tabel relasi
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna dan role berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
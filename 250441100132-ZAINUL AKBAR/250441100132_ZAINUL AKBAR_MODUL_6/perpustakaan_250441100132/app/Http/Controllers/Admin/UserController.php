<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Menampilkan daftar pengguna dan role mereka
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    // Memperbarui role pengguna
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        // Sync role menggunakan Spatie
        $user->syncRoles([$request->role]);

        // CEK: Jika user yang rolenya diubah adalah AKUN SENDIRI yang sedang login
        if (auth()->id() === $user->id) {
            // Logout & hapus session agar cache role bersih total
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Direct langsung ke halaman Login
            return redirect()->route('login')->with('success', 'Role Anda telah diubah. Silakan login kembali.');
        }

        return redirect()->route('admin.users.index')->with('success', 'Role pengguna berhasil diperbarui!');
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        // Cegah menghapus akun sendiri saat sedang login
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus!');
    }
}
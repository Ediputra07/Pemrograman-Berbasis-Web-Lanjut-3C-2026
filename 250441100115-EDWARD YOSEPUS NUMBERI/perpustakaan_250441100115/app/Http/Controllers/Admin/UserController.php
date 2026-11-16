<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Menampilkan daftar seluruh pengguna
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan form edit role pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Mengambil semua daftar role
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // Memproses penyimpanan perubahan role pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Sinkronisasi role (mengganti role lama dengan role baru)
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'Role pengguna berhasil diperbarui.');
    }
}
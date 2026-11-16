<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Menampilkan daftar seluruh pengguna beserta rolenya
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan form edit user dan role-nya
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // Memproses update data dan role pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Update nama dan email jika diperlukan
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Menetapkan/mengubah role pengguna (admin, petugas, atau siswa)
        $user->syncRoles($request->role);

        return redirect()->route('admin.users.index')->with('success', 'Data dan role pengguna berhasil diperbarui!');
    }
}
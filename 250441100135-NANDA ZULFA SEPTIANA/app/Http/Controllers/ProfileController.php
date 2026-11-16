<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Menampilkan halaman profil mandiri
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // Mengupdate data profil (Nama & Email)
    public function update(Request $request)
{
    // 1. Lakukan validasi data
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
    ]);

    // 2. Isi dan simpan menggunakan data yang sudah divalidasi ($validated)
    $request->user()->fill($validated);

    if ($request->user()->isDirty('email')) {
        $request->user()->email_verified_at = null;
    }

    $request->user()->save();

    return back()->with('success', 'Profil berhasil diperbarui!');
}
}

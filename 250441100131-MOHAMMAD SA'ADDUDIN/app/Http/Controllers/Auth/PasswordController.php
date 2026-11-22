<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /** PUT /password: ubah kata sandi milik pengguna yang sedang login. */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Password::defaults(), 'confirmed'],
        ], [
            'required'                 => ':Attribute wajib diisi.',
            'current_password'         => 'Kata sandi saat ini tidak sesuai.',
            'password.confirmed'       => 'Konfirmasi kata sandi baru tidak sama.',
            'password.min'             => 'Kata sandi baru minimal :min karakter.',
        ], [
            'current_password' => 'kata sandi saat ini',
            'password'         => 'kata sandi baru',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}

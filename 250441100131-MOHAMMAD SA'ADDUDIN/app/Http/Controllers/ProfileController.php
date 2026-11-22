<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Hanya memakai $request->user() (tanpa ID di URL), sehingga pengguna
     * hanya dapat melihat dan mengubah profil MILIKNYA SENDIRI.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('profile.edit', [
            'user'   => $user,
            'anggota' => $user->pastikanAnggota(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        DB::transaction(function () use ($user, $data) {
            $user->fill([
                'name'  => $data['name'],
                'email' => $data['email'],
            ])->save();

            $user->pastikanAnggota()->update([
                'nama'       => $data['name'],
                'email'      => $data['email'],
                'no_telepon' => $data['no_telepon'],
            ]);
        });

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}

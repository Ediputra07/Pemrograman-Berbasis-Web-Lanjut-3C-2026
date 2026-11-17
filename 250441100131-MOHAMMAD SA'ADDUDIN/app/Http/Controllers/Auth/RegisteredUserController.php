<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', 'unique:anggotas,email'],
            'no_telepon' => ['required', 'string', 'regex:/^08[0-9]{8,12}$/'],
            'password'   => ['required', 'confirmed', Password::defaults()],
        ], [
            'required'         => ':Attribute wajib diisi.',
            'max'              => ':Attribute maksimal :max karakter.',
            'email'            => 'Format email tidak valid.',
            'lowercase'        => 'Email harus ditulis dengan huruf kecil.',
            'email.unique'     => 'Email ini sudah terdaftar.',
            'no_telepon.regex' => 'No. telepon harus diawali 08 dan berisi 10-14 angka.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama.',
            'password.min'     => 'Kata sandi minimal :min karakter.',
        ], [
            'name'       => 'nama',
            'email'      => 'email',
            'no_telepon' => 'no. telepon',
            'password'   => 'kata sandi',
        ]);

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']), 
            ]);

            $user->assignRole('siswa');

            $user->anggota()->create([
                'nama'       => $data['name'],
                'email'      => $data['email'],
                'no_telepon' => $data['no_telepon'],
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

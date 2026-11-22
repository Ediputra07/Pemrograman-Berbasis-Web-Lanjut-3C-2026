<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

//Kelola akun pengguna.
class PenggunaController extends Controller
{
    private const ROLE = ['admin', 'petugas', 'siswa'];

    public function index(): View
    {
        return view('admin.pengguna.index', [
            'daftar'     => User::with('roles')->orderBy('name')->paginate(10),
            'daftarRole' => self::ROLE,
        ]);
    }

    public function create(): View
    {
        return view('admin.pengguna.form', [
            'pengguna'   => null,
            'daftarRole' => self::ROLE,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', 'unique:anggotas,email'],
            'no_telepon' => ['required', 'string', 'regex:/^08[0-9]{8,12}$/'],
            'password'   => ['required', 'confirmed', Password::defaults()],
            'role'       => ['nullable', Rule::in(self::ROLE)],
        ], $this->pesan(), $this->atribut());

        // Role hanya boleh dipilih oleh yang berwenang; selain itu default 'siswa'
        $role = $request->user()->can('kelola role pengguna')
            ? ($data['role'] ?? 'siswa')
            : 'siswa';

        DB::transaction(function () use ($data, $role) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole($role);

            $user->anggota()->create([
                'nama'       => $data['name'],
                'email'      => $data['email'],
                'no_telepon' => $data['no_telepon'],
            ]);
        });

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $pengguna): View
    {
        return view('admin.pengguna.form', [
            'pengguna'   => $pengguna->load('anggota'),
            'daftarRole' => self::ROLE,
        ]);
    }

    public function update(Request $request, User $pengguna): RedirectResponse
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($pengguna->id),
                Rule::unique('anggotas', 'email')->ignore($pengguna->anggota?->id),
            ],
            'no_telepon' => ['required', 'string', 'regex:/^08[0-9]{8,12}$/'],
            'password'   => ['nullable', 'confirmed', Password::defaults()],
        ], $this->pesan(), $this->atribut());

        DB::transaction(function () use ($pengguna, $data) {
            $pengguna->fill(['name' => $data['name'], 'email' => $data['email']]);

            if (! empty($data['password'])) {
                $pengguna->password = Hash::make($data['password']);
            }

            $pengguna->save();

            $pengguna->pastikanAnggota()->update([
                'nama'       => $data['name'],
                'email'      => $data['email'],
                'no_telepon' => $data['no_telepon'],
            ]);
        });

        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    
    public function updateRole(Request $request, User $pengguna): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(self::ROLE)],
        ], [
            'role.required' => 'Role wajib dipilih.',
            'role.in'       => 'Role yang dipilih tidak valid.',
        ]);

        // Cegah admin menurunkan role dirinya sendiri sehingga sistem tanpa admin
        if ($pengguna->is($request->user())) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $pengguna->syncRoles($data['role']);

        return back()->with('success', "Role {$pengguna->name} diubah menjadi {$data['role']}.");
    }

    public function destroy(Request $request, User $pengguna): RedirectResponse
    {
        if ($pengguna->is($request->user())) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    private function pesan(): array
    {
        return [
            'required'           => ':Attribute wajib diisi.',
            'max'                => ':Attribute maksimal :max karakter.',
            'email'              => 'Format email tidak valid.',
            'lowercase'          => 'Email harus ditulis dengan huruf kecil.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'no_telepon.regex'   => 'No. telepon harus diawali 08 dan berisi 10-14 angka.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama.',
            'password.min'       => 'Kata sandi minimal :min karakter.',
            'role.in'            => 'Role yang dipilih tidak valid.',
        ];
    }

    private function atribut(): array
    {
        return [
            'name'       => 'nama',
            'email'      => 'email',
            'no_telepon' => 'no. telepon',
            'password'   => 'kata sandi',
        ];
    }
}

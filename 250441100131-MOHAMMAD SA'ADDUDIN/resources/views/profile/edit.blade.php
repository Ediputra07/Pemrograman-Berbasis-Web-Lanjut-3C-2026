@extends('layouts.app')

@section('judul', 'Profil Saya')

@section('konten')
    <h2>Profil Saya</h2>
    <p class="catatan">Peran akun: <strong>{{ $user->getRoleNames()->first() ?? 'tanpa role' }}</strong>.
        Anda hanya dapat melihat dan mengubah data milik Anda sendiri.</p>

    <section class="kartu-form kartu-auth" aria-labelledby="judul-profil">
        <h3 id="judul-profil">Informasi Profil</h3>

        @can('ubah profil sendiri')
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="bidang">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                    @error('name')
                        <small class="galat">{{ $message }}</small>
                    @enderror
                </div>

                <div class="bidang">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')
                        <small class="galat">{{ $message }}</small>
                    @enderror
                </div>

                <div class="bidang">
                    <label for="no_telepon">No. telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $anggota->no_telepon) }}" inputmode="numeric" required>
                    @error('no_telepon')
                        <small class="galat">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-buku__aksi">
                    <button type="submit" class="tombol">Simpan Profil</button>
                </div>
            </form>
        @endcan
    </section>

    @can('ubah profil sendiri')
        <section class="kartu-form kartu-auth" aria-labelledby="judul-sandi">
            <h3 id="judul-sandi">Ubah Kata Sandi</h3>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="bidang">
                    <label for="current_password">Kata sandi saat ini</label>
                    <input type="password" id="current_password" name="current_password" autocomplete="current-password" required>
                    @if ($errors->updatePassword->has('current_password'))
                        <small class="galat">{{ $errors->updatePassword->first('current_password') }}</small>
                    @endif
                </div>

                <div class="bidang">
                    <label for="password">Kata sandi baru</label>
                    <input type="password" id="password" name="password" autocomplete="new-password" required>
                    @if ($errors->updatePassword->has('password'))
                        <small class="galat">{{ $errors->updatePassword->first('password') }}</small>
                    @endif
                </div>

                <div class="bidang">
                    <label for="password_confirmation">Konfirmasi kata sandi baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
                </div>

                <div class="form-buku__aksi">
                    <button type="submit" class="tombol">Ubah Kata Sandi</button>
                </div>
            </form>
        </section>
    @endcan
@endsection

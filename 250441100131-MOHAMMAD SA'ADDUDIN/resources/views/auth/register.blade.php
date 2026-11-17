@extends('layouts.app')

@section('judul', 'Daftar')

@section('konten')
    <section class="kartu-form kartu-auth" aria-labelledby="judul-daftar">
        <h2 id="judul-daftar">Daftar Akun</h2>
        <p class="catatan">Akun yang mendaftar sendiri otomatis berperan sebagai <strong>Siswa</strong>.
            Role Petugas atau Admin hanya dapat ditetapkan oleh Admin.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="bidang">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name')
                    <small class="galat">{{ $message }}</small>
                @enderror
            </div>

            <div class="bidang">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                @error('email')
                    <small class="galat">{{ $message }}</small>
                @enderror
            </div>

            <div class="bidang">
                <label for="no_telepon">No. telepon</label>
                <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                       inputmode="numeric" placeholder="mis. 081234567890" required>
                @error('no_telepon')
                    <small class="galat">{{ $message }}</small>
                @enderror
            </div>

            <div class="bidang">
                <label for="password">Kata sandi</label>
                <input type="password" id="password" name="password" required autocomplete="new-password">
                @error('password')
                    <small class="galat">{{ $message }}</small>
                @enderror
            </div>

            <div class="bidang">
                <label for="password_confirmation">Konfirmasi kata sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="form-buku__aksi">
                <button type="submit" class="tombol">Daftar</button>
                <a href="{{ route('login') }}" class="tautan-kembali">Sudah punya akun? Masuk</a>
            </div>
        </form>
    </section>
@endsection

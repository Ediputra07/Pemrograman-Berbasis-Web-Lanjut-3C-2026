@extends('layouts.app')

@section('judul', 'Masuk')

@section('konten')
    <section class="kartu-form kartu-auth" aria-labelledby="judul-login">
        <h2 id="judul-login">Masuk</h2>
        <p class="catatan">Masuk dengan akun perpustakaan Anda.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="bidang">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username">
                @error('email')
                    <small class="galat">{{ $message }}</small>
                @enderror
            </div>

            <div class="bidang">
                <label for="password">Kata sandi</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
                @error('password')
                    <small class="galat">{{ $message }}</small>
                @enderror
            </div>

            <div class="bidang bidang--centang">
                <label for="remember">
                    <input type="checkbox" id="remember" name="remember" value="1">
                    Ingat saya
                </label>
            </div>

            <div class="form-buku__aksi">
                <button type="submit" class="tombol">Masuk</button>
                <a href="{{ route('register') }}" class="tautan-kembali">Belum punya akun? Daftar</a>
            </div>
        </form>
    </section>
@endsection

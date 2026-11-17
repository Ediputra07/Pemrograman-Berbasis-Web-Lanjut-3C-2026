@extends('layouts.app')

@section('judul', 'Akses Ditolak')

@section('konten')
    <article class="detail-buku detail-buku--kosong">
        <p class="detail-buku__rak">Kesalahan 403</p>
        <h2>Akses ditolak</h2>
        <p>Anda tidak memiliki izin untuk membuka halaman atau menjalankan aksi ini.</p>
    </article>

    @auth
        <a href="{{ route('dashboard') }}" class="tautan-kembali">&larr; Kembali ke dashboard</a>
    @else
        <a href="{{ route('login') }}" class="tautan-kembali">&larr; Masuk</a>
    @endauth
@endsection

@extends('layouts.app')

@section('title', 'Beranda - Perpustakaan')

@section('content')

    <section class="hero">

        <h2>Selamat Datang di Perpustakaan</h2>

        <p>
            Selamat datang di aplikasi perpustakaan sederhana.
        </p>

        <a href="{{ route('buku.index') }}" class="btn">
            Lihat Daftar Buku
        </a>

    </section>
@endsection
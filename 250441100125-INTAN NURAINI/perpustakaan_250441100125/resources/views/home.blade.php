@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<div class="hero">
    <h2>Selamat Datang di Perpustakaan!!</h2>

    <p>
        Temukan berbagai koleksi buku yang menarik dan bermanfaat
        untuk menambah wawasan.
    </p>

    <a href="{{ route('buku.index') }}" class="btn">
        Lihat Daftar Buku
    </a>
</div>

@endsection
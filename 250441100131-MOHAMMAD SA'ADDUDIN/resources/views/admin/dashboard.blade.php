@extends('layouts.app')

@section('judul', 'Dashboard Admin')

@section('konten')
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    {{-- Pengecekan permission di tampilan --}}
    @can('kelola data pengguna')
        <div class="alert alert--success">Anda memiliki hak akses untuk <strong>kelola pengguna</strong> dan role.</div>
    @endcan

    <div class="statistik">
        <div class="statistik__kartu"><span class="statistik__angka">{{ $jumlahAdmin }}</span><span class="statistik__label">Admin</span></div>
        <div class="statistik__kartu"><span class="statistik__angka">{{ $jumlahPetugas }}</span><span class="statistik__label">Petugas</span></div>
        <div class="statistik__kartu"><span class="statistik__angka">{{ $jumlahSiswa }}</span><span class="statistik__label">Siswa</span></div>
        <div class="statistik__kartu"><span class="statistik__angka">{{ $jumlahBuku }}</span><span class="statistik__label">Buku</span></div>
        <div class="statistik__kartu"><span class="statistik__angka">{{ $jumlahPinjam }}</span><span class="statistik__label">Sedang dipinjam</span></div>
        <div class="statistik__kartu"><span class="statistik__angka">{{ $menungguSetuju }}</span><span class="statistik__label">Menunggu persetujuan</span></div>
    </div>

    <div class="pintasan">
        @can('kelola data pengguna')
            <a href="{{ route('admin.pengguna.index') }}" class="tombol">Kelola Pengguna &amp; Role</a>
        @endcan
        @can('kelola-buku')
            <a href="{{ route('buku.index') }}" class="tombol">Kelola Buku</a>
        @endcan
        @can('kelola peminjaman')
            <a href="{{ route('kelola.peminjaman.index') }}" class="tombol">Peminjaman</a>
        @endcan
        @can('kelola pengembalian')
            <a href="{{ route('kelola.pengembalian.index') }}" class="tombol">Pengembalian</a>
        @endcan
        @can('lihat laporan perpustakaan')
            <a href="{{ route('laporan.index') }}" class="tombol">Laporan</a>
        @endcan
    </div>
@endsection

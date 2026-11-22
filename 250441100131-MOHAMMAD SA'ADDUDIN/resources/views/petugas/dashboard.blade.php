@extends('layouts.app')

@section('judul', 'Dashboard Petugas')

@section('konten')
    <h2>Dashboard Petugas</h2>
    <p>Selamat bertugas, {{ auth()->user()->name }}.</p>

    <div class="statistik">
        <div class="statistik__kartu"><span class="statistik__angka">{{ $menungguSetuju }}</span><span class="statistik__label">Menunggu persetujuan</span></div>
        <div class="statistik__kartu"><span class="statistik__angka">{{ $sedangDipinjam }}</span><span class="statistik__label">Sedang dipinjam</span></div>
        <div class="statistik__kartu"><span class="statistik__angka">{{ $jumlahBuku }}</span><span class="statistik__label">Buku</span></div>
    </div>

    <div class="pintasan">
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

    <h3>Pengajuan terbaru</h3>
    @if ($pengajuanBaru->isEmpty())
        <p class="catatan">Tidak ada pengajuan yang menunggu.</p>
    @else
        <div class="tabel-gulir">
            <table class="tabel">
                <thead>
                    <tr><th>Anggota</th><th>Buku</th><th>Tanggal</th></tr>
                </thead>
                <tbody>
                    @foreach ($pengajuanBaru as $p)
                        <tr>
                            <td>{{ $p->anggota->nama }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tanggal_pinjam->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection

@extends('layouts.app')

@section('judul', 'Dashboard')

@section('konten')
    <h2>Halo, {{ auth()->user()->name }}</h2>
    <p class="catatan">Ringkasan peminjaman milik Anda.</p>

    <div class="statistik">
        <div class="statistik__kartu">
            <span class="statistik__angka">{{ $aktif->count() }}</span>
            <span class="statistik__label">Pengajuan / peminjaman berjalan</span>
        </div>
        <div class="statistik__kartu">
            <span class="statistik__angka">{{ $totalRiwayat }}</span>
            <span class="statistik__label">Total catatan peminjaman</span>
        </div>
    </div>

    <h3>Sedang berjalan</h3>
    @if ($aktif->isEmpty())
        <p class="catatan">Belum ada pengajuan atau peminjaman yang berjalan.
            @can('lihat daftar buku')
                <a href="{{ route('buku.index') }}">Telusuri daftar buku</a>.
            @endcan
        </p>
    @else
        <div class="tabel-gulir">
            <table class="tabel">
                <thead>
                    <tr><th>Buku</th><th>Tanggal</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach ($aktif as $p)
                        <tr>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tanggal_pinjam->format('d-m-Y') }}</td>
                            <td><x-badge-status :status="$p->status" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection

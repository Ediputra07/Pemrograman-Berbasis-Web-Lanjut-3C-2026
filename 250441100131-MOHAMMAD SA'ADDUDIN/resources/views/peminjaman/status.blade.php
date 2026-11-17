@extends('layouts.app')

@section('judul', 'Peminjaman Saya')

@section('konten')
    <h2>Peminjaman Saya</h2>
    <p class="catatan">Pengajuan dan peminjaman yang sedang berjalan.</p>

    @if ($daftar->isEmpty())
        <p class="catatan">Belum ada pengajuan atau peminjaman yang berjalan.
            @can('lihat daftar buku')
                <a href="{{ route('buku.index') }}">Telusuri daftar buku</a>.
            @endcan
        </p>
    @else
        <div class="tabel-gulir">
            <table class="tabel">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftar as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><a href="{{ route('buku.show', ['id' => $p->buku_id]) }}">{{ $p->buku->judul }}</a></td>
                            <td>{{ $p->buku->kategori->nama }}</td>
                            <td>{{ $p->tanggal_pinjam->format('d-m-Y') }}</td>
                            <td><x-badge-status :status="$p->status" /></td>
                            <td><a href="{{ route('peminjaman.show', ['id' => $p->id]) }}">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @can('melihat riwayat peminjaman sendiri')
        <a href="{{ route('peminjaman.riwayat') }}" class="tautan-kembali">Lihat riwayat peminjaman &rarr;</a>
    @endcan
@endsection

@extends('layouts.app')

@section('judul', 'Riwayat Peminjaman')

@section('konten')
    <h2>Riwayat Peminjaman</h2>
    <p class="catatan">Anggota: <strong>{{ $anggota->nama }}</strong></p>

    @if ($daftar->isEmpty())
        <p class="catatan">Belum ada riwayat peminjaman.</p>
    @else
        <div class="tabel-gulir">
            <table class="tabel">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Tanggal pinjam</th>
                        <th>Tanggal kembali</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftar as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tanggal_pinjam->format('d-m-Y') }}</td>
                            <td>{{ $p->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
                            <td><x-badge-status :status="$p->status" /></td>
                            <td><a href="{{ route('peminjaman.show', ['id' => $p->id]) }}">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection

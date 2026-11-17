@extends('layouts.app')

@section('judul', 'Pengembalian Buku')

@section('konten')
    <h2>Pengembalian Buku</h2>
    <p class="catatan">Daftar buku yang sedang dipinjam. Catat pengembalian saat buku sudah diterima.</p>

    <div class="tabel-gulir">
        <table class="tabel">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tanggal pinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftar as $i => $p)
                    <tr>
                        <td>{{ $daftar->firstItem() + $i }}</td>
                        <td>{{ $p->anggota->nama }}</td>
                        <td>{{ $p->buku->judul }}</td>
                        <td>{{ $p->tanggal_pinjam->format('d-m-Y') }}</td>
                        <td class="aksi">
                            @can('mencatat pengembalian buku')
                                <form method="POST" action="{{ route('kelola.pengembalian.catat', $p) }}" class="form-inline"
                                      onsubmit="return confirm('Catat buku ini sebagai sudah dikembalikan?');">
                                    @csrf
                                    <button type="submit" class="tombol tombol--kecil">Catat pengembalian</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="tabel__info">Tidak ada buku yang sedang dipinjam.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('partials.paginasi', ['paginator' => $daftar])
@endsection

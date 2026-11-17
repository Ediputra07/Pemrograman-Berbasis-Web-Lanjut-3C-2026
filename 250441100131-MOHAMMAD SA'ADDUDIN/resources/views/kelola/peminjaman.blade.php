@extends('layouts.app')

@section('judul', 'Kelola Peminjaman')

@section('konten')
    <h2>Kelola Peminjaman</h2>

    <div class="filter">
        <a href="{{ route('kelola.peminjaman.index') }}" @class(['filter__item', 'filter__item--aktif' => ! $status])>Semua</a>
        @foreach (\App\Models\Peminjaman::DAFTAR_STATUS as $s)
            <a href="{{ route('kelola.peminjaman.index', ['status' => $s]) }}"
               @class(['filter__item', 'filter__item--aktif' => $status === $s])>{{ ucfirst($s) }}</a>
        @endforeach
    </div>

    <div class="tabel-gulir">
        <table class="tabel">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tanggal pinjam</th>
                    <th>Tanggal kembali</th>
                    <th>Status</th>
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
                        <td>{{ $p->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
                        <td><x-badge-status :status="$p->status" /></td>
                        <td class="aksi">
                            @can('memproses persetujuan peminjaman')
                                @if ($p->status === \App\Models\Peminjaman::DIAJUKAN)
                                    <form method="POST" action="{{ route('kelola.peminjaman.setujui', $p) }}" class="form-inline">
                                        @csrf
                                        <button type="submit" class="tombol tombol--kecil">Setujui</button>
                                    </form>
                                    <form method="POST" action="{{ route('kelola.peminjaman.tolak', $p) }}" class="form-inline">
                                        @csrf
                                        <button type="submit" class="tombol tombol--kecil tombol--bahaya">Tolak</button>
                                    </form>
                                @endif
                            @endcan
                            <a href="{{ route('anggota.riwayat', $p->anggota_id) }}" class="tombol tombol--kecil tombol--sekunder">Riwayat anggota</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="tabel__info">Tidak ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('partials.paginasi', ['paginator' => $daftar])
@endsection

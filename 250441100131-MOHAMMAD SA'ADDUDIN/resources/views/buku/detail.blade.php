@extends('layouts.app')

@section('judul', $buku ? $buku['judul'] : 'Buku Tidak Ditemukan')

@section('konten')
    @if ($buku)
        <article class="detail-buku">
            <p class="detail-buku__rak">Rak {{ $buku['kategori'] }}</p>
            <h2>{{ $buku['judul'] }}</h2>

            <dl class="detail-buku__meta">
                <div>
                    <dt>Penulis</dt>
                    <dd>{{ $buku['penulis'] }}</dd>
                </div>
                <div>
                    <dt>Tahun terbit</dt>
                    <dd>{{ $buku['tahun_terbit'] }}</dd>
                </div>
            </dl>

            @isset($buku['tautan_baca'])
                <a href="{{ $buku['tautan_baca'] }}" class="tombol" target="_blank" rel="noopener">
                    Baca buku ini
                </a>
            @endisset

            {{-- Modul 5: pengajuan peminjaman (permission 'mengajukan peminjaman buku') --}}
            @can('mengajukan peminjaman buku')
                @if ($sudahAktif)
                    <p class="catatan">Anda sudah memiliki pengajuan atau peminjaman yang berjalan untuk buku ini.
                        <a href="{{ route('peminjaman.status') }}">Lihat status</a>.</p>
                @else
                    <form method="POST" action="{{ route('peminjaman.store') }}" class="form-inline">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $buku['id'] }}">
                        <button type="submit" class="tombol">Ajukan peminjaman</button>
                    </form>
                @endif
            @endcan
        </article>
    @else
        <article class="detail-buku detail-buku--kosong">
            <h2>Buku tidak ditemukan</h2>
            <p>Data buku dengan ID tersebut belum ada di katalog kami.</p>
        </article>
    @endif

    <a href="{{ route('buku.index') }}" class="tautan-kembali">&larr; Kembali ke daftar buku</a>
@endsection

@extends('layouts.app')

@section('judul', 'Detail Peminjaman')

@section('konten')
    <h2>Detail Peminjaman #{{ $peminjaman->id }}</h2>

    <article class="detail-buku">
        <p class="detail-buku__rak">Rak {{ $peminjaman->buku->kategori->nama }}</p>
        <h3>{{ $peminjaman->buku->judul }}</h3>

        <dl class="detail-buku__meta">
            <div>
                <dt>Peminjam</dt>
                <dd>{{ $peminjaman->anggota->nama }}</dd>
            </div>
            <div>
                <dt>Email</dt>
                <dd>{{ $peminjaman->anggota->email }}</dd>
            </div>
            <div>
                <dt>Tanggal pinjam</dt>
                <dd>{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</dd>
            </div>
            <div>
                <dt>Tanggal kembali</dt>
                <dd>{{ $peminjaman->tanggal_kembali?->format('d-m-Y') ?? '-' }}</dd>
            </div>
            <div>
                <dt>Status</dt>
                <dd><x-badge-status :status="$peminjaman->status" /></dd>
            </div>
        </dl>
    </article>

    <a href="{{ route('buku.index') }}" class="tautan-kembali">&larr; Kembali ke daftar buku</a>
@endsection

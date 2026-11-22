@extends('layouts.app')

@section('title', 'Detail Buku - Perpustakaan')

@section('content')

    @if ($book)

        <div class="detail-card">

            <div class="book-icon detail-icon">
                📖
            </div>

            <h2>{{ $book['judul'] }}</h2>

            <div class="detail-info">

                <p>
                    <strong>ID Buku:</strong>
                    {{ $book['id'] }}
                </p>

                <p>
                    <strong>Judul:</strong>
                    {{ $book['judul'] }}
                </p>

                <p>
                    <strong>Penulis:</strong>
                    {{ $book['penulis'] }}
                </p>

                <p>
                    <strong>Tahun Terbit:</strong>
                    {{ $book['tahun'] }}
                </p>

                <p>
                    <strong>Kategori:</strong>
                    {{ $book['kategori'] }}
                </p>

            </div>

            <a href="{{ route('buku.index') }}" class="btn">
                ← Kembali ke Daftar Buku
            </a>

        </div>

    @else

        <div class="not-found">

            <h2>Buku Tidak Ditemukan</h2>

            <p>
                Maaf, data buku yang kamu cari tidak tersedia.
            </p>

            <a href="{{ route('buku.index') }}" class="btn">
                Kembali ke Daftar Buku
            </a>

        </div>

    @endif

@endsection
@extends('layouts.app')

@section('judul', 'Daftar Buku')

@section('konten')
<h2>Daftar Buku</h2>

{{-- @can hanya merapikan tampilan; pengamanan sebenarnya ada di middleware can:kelola-buku pada route --}}
@can('kelola-buku')
<p><a href="{{ route('buku.create') }}" class="tombol">Tambah Buku</a></p>
@endcan

<div class="tabel-gulir">
    <table class="tabel">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                @can('kelola-buku')
                <th>Aksi</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarBuku as $buku)
            <tr>
                <td>{{ $daftarBuku->firstItem() + $loop->index }}</td>
                <td>{{ $buku->kategori->nama }}</td>
                <td><a href="{{ route('buku.show', ['id' => $buku->id]) }}">
                        {{ $buku->judul }}</a></td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ $buku->tahun_terbit }}</td>
                @can('kelola-buku')
                <td class="aksi">
                    <a href="{{ route('buku.edit', $buku) }}" class="tombol tombol--kecil tombol--peringatan">Ubah</a>
                    {{-- A3 Soal 1: sengaja menggunakan tautan GET untuk membuktikan CSRF. --}}
                    <form action="{{ route('buku.destroy', $buku) }}"
                        method="POST"
                        style="display: inline;">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="tombol tombol--kecil tombol--bahaya"
                            onclick="return confirm('Hapus buku ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
                @endcan
            </tr>
            @empty
            <tr>
                <td colspan="{{ auth()->user()->can('kelola-buku') ? 6 : 5 }}" class="tabel__info">Belum ada data buku.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('partials.paginasi', ['paginator' => $daftarBuku])
@endsection

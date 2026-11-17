@extends('layouts.app')

@php($mengubah = $buku->exists)

@section('judul', $mengubah ? 'Ubah Buku' : 'Tambah Buku')

@section('konten')
    <h2>{{ $mengubah ? 'Ubah Buku' : 'Tambah Buku' }}</h2>

    <section class="kartu-form">
        <form method="POST" action="{{ $mengubah ? route('buku.update', $buku) : route('buku.store') }}" novalidate>
            @csrf
            @if ($mengubah)
                @method('PUT')
            @endif

            <div class="form-buku__grid">
                <div class="bidang">
                    <label for="kategori_id">Kategori</label>
                    <select id="kategori_id" name="kategori_id">
                        <option value="">-- Pilih kategori --</option>
                        @foreach ($daftarKategori as $kategori)
                            <option value="{{ $kategori->id }}" @selected(old('kategori_id', $buku->kategori_id) == $kategori->id)>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')<small class="galat">{{ $message }}</small>@enderror
                </div>

                <div class="bidang">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" autocomplete="off">
                    @error('judul')<small class="galat">{{ $message }}</small>@enderror
                </div>

                <div class="bidang">
                    <label for="penulis">Penulis</label>
                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}" autocomplete="off">
                    @error('penulis')<small class="galat">{{ $message }}</small>@enderror
                </div>

                <div class="bidang">
                    <label for="tahun_terbit">Tahun terbit</label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" placeholder="mis. 2024">
                    @error('tahun_terbit')<small class="galat">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="form-buku__aksi">
                <button type="submit" class="tombol">{{ $mengubah ? 'Simpan Perubahan' : 'Tambah Buku' }}</button>
                <a href="{{ route('buku.index') }}" class="tombol tombol--sekunder">Batal</a>
            </div>
        </form>
    </section>
@endsection

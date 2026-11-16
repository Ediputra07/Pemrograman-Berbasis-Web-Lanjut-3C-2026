@extends('layouts.app')

@section('judul', 'Daftar Buku')

@section('konten')
    {{-- Halaman ini hanya kerangka. Seluruh data buku diambil JavaScript dari API (/api/buku). --}}
    <div id="app-buku"
         data-api-url="{{ route('api.buku.index') }}"
         data-detail-url="{{ route('buku.show', ['id' => '__ID__']) }}">

        <h2>Daftar Buku</h2>

        <div id="alert-area" aria-live="polite"></div>

        <section class="kartu-form" aria-labelledby="judul-form">
            <h3 id="judul-form">Tambah Buku</h3>

            <form id="form-buku" novalidate>
                <input type="hidden" id="buku-id">

                <div class="form-buku__grid">
                    <div class="bidang">
                        <label for="buku-kategori_id">Kategori</label>
                        <select id="buku-kategori_id" name="kategori_id">
                            <option value="">-- Pilih kategori --</option>
                            @foreach ($daftarKategori as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                        <small class="galat" id="err-kategori_id"></small>
                    </div>

                    <div class="bidang">
                        <label for="buku-judul">Judul</label>
                        <input type="text" id="buku-judul" name="judul" autocomplete="off">
                        <small class="galat" id="err-judul"></small>
                    </div>

                    <div class="bidang">
                        <label for="buku-penulis">Penulis</label>
                        <input type="text" id="buku-penulis" name="penulis" autocomplete="off">
                        <small class="galat" id="err-penulis"></small>
                    </div>

                    <div class="bidang">
                        <label for="buku-tahun_terbit">Tahun terbit</label>
                        <input type="number" id="buku-tahun_terbit" name="tahun_terbit" placeholder="mis. 2024">
                        <small class="galat" id="err-tahun_terbit"></small>
                    </div>
                </div>

                <div class="form-buku__aksi">
                    <button type="submit" id="btn-simpan" class="tombol">Tambah Buku</button>
                    <button type="button" id="btn-batal" class="tombol tombol--sekunder" hidden>Batal</button>
                </div>
            </form>
        </section>

        <div class="tabel-gulir">
            <table class="tabel">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody-buku">
                    <tr><td colspan="6" class="tabel__info">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <noscript><p class="galat">Halaman ini memerlukan JavaScript untuk menampilkan data buku.</p></noscript>

        <div class="paginasi">
            <button type="button" id="btn-prev" class="tombol tombol--kecil tombol--sekunder" disabled aria-label="Halaman sebelumnya">&laquo;</button>
            <span id="info-halaman"></span>
            <button type="button" id="btn-next" class="tombol tombol--kecil tombol--sekunder" disabled aria-label="Halaman berikutnya">&raquo;</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/buku-client.js') }}"></script>
@endpush

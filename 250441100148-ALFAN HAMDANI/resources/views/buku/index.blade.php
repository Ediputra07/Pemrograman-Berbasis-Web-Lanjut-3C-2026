<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-blue-600 -m-6 p-6">
            {{ __('Kelola Data Buku') }}
        </h2>
    </x-slot>

    <!-- Memuat CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h2 class="mb-4">Data Buku Perpustakaan Cendekia</h2>

                    <!-- Notifikasi Sukses / Pesan -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Form Tambah Buku (Menggunakan Route POST biasa) -->
                    <div class="card mb-4 p-3 shadow-sm">
                        <h4>Tambah Buku Baru</h4>
                        @can('kelola-buku')
                            <form action="{{ route('buku.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Kategori ID</label>
                                    <input type="text" name="kategori_id" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Judul Buku</label>
                                    <input type="text" name="judul" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Penulis</label>
                                    <input type="text" name="penulis" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Terbit</label>
                                    <input type="number" name="tahun_terbit" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        @endcan
                    </div>

                    <!-- Tabel Data Buku (Dirender langsung via Blade) -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Tahun Terbit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bukus as $buku)
                                    <tr>
                                        <td>{{ $buku->kategori_id ?? $buku->kategori }}</td>

                                        <td>{{ $buku->judul }}</td>
                                        <td>{{ $buku->penulis }}</td>
                                        <td>{{ $buku->tahun_terbit }}</td>
                                        <td>
                                            @can('kelola-buku')
                                                <!-- Tombol Hapus (Menyesuaikan Soal A3/Soal 2c nantinya) -->
                                                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
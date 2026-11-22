<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Buku - Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="page-title mb-4 flex justify-between items-center">
                        <p class="text-gray-600">Koleksi buku</p>
                        @can('kelola-buku')
                            <a href="{{ route('buku.create') }}" style="background: #28a745; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px;">+ Tambah Buku</a>
                        @endcan
                    </div>

                    <!-- NOTIFIKASI SUKSES ATAU ERROR -->
                    @if(session('success'))
                        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #c3e6cb;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #f5c6cb;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- TABEL DATA BUKU -->
                    <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <!-- DITAMBAHKAN HEADER KOLOM ID -->
                                <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Kategori</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Judul</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Penulis</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Tahun Terbit</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $buku)
                                <tr>
                                    <!-- DITAMBAHKAN MENAMPILKAN ID BUKU -->
                                    <td style="padding: 10px; text-align:center; border: 1px solid #ddd; font-weight: bold;">
                                        {{ $buku->id }}
                                    </td>

                                    <!-- Menampilkan NAMA Kategori dari Relasi -->
                                    <td style="padding: 10px; text-align:center; border: 1px solid #ddd;">
                                        {{ $buku->kategori->nama ?? '-' }}
                                    </td>

                                    <!-- Penggunaan Objek Eloquent ($buku->field) -->
                                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $buku->judul }}</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $buku->penulis }}</td>
                                    <td style="padding: 10px; text-align:center; border: 1px solid #ddd;">{{ $buku->tahun_terbit }}</td>
                                    
                                    <td style="padding: 10px; text-align:center; border: 1px solid #ddd;">
                                        @role('siswa')
                                            <form action="{{ route('peminjaman.store') }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                                <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">
                                                <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d', strtotime('+7 days')) }}">

                                                <button type="submit" onclick="return confirm('Apakah Anda ingin meminjam buku ini?')" style="background: #28a745; color: white; border: none; padding: 5px 12px; cursor: pointer; border-radius:3px; font-weight: bold;">
                                                    Pinjam
                                                </button>
                                            </form>
                                        @endrole

                                        @can('kelola-buku')
                                            <a href="{{ route('buku.edit', $buku->id) }}" style="background: #ffc107; color: black; padding: 4px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold; margin-right: 5px;">Edit</a>
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Hapus buku ini?')" style="background: #dc3545; color: white; border: none; padding: 4px 10px; cursor: pointer; border-radius: 3px; font-size: 12px; font-weight: bold;">Hapus</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding: 15px; text-align: center; color: #666;">
                                        Belum ada data buku yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
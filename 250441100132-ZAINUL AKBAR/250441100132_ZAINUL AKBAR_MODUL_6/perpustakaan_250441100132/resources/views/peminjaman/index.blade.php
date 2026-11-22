<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data & Riwayat Peminjaman Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- TOMBOL BIRU MENU DAFTAR BUKU -->
                    <div style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
                        <a href="{{ route('buku.index') }}" style="padding: 8px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
                            Lihat Daftar Buku
                        </a>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <h3 class="font-bold text-lg mb-3">Daftar Sirkulasi Peminjaman</h3>
                    </div>

                    <!-- TABEL DATA PEMINJAMAN -->
                    <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">No</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Nama Peminjam</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Judul Buku</th>
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Tanggal Pinjam</th>
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Tanggal Kembali</th>
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Status</th>
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $index => $item)
                                <tr>
                                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">{{ $index + 1 }}</td>
                                    
                                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: #333;">
                                        {{ $item->user->name ?? '-' }}
                                    </td>

                                    <td style="padding: 10px; border: 1px solid #ddd;">
                                        {{ $item->buku->judul ?? $item->buku->judul_buku ?? '-' }}
                                    </td>
                                    
                                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d F Y') }}
                                    </td>
                                    
                                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d F Y') }}
                                    </td>

                                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                                        <span style="padding: 3px 8px; border-radius: 4px; background: {{ $item->status == 'Dipinjam' ? '#ffc107' : '#28a745' }}; color: {{ $item->status == 'Dipinjam' ? '#000' : '#fff' }}; font-size: 12px; font-weight: bold;">
                                            {{ $item->status }}
                                        </span>
                                    </td>

                                    <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                                        <!-- Tombol Detail untuk semua role (Siswa, Petugas, Admin) -->
                                        <a href="{{ route('peminjaman.show', $item->id) }}" style="background: #17a2b8; color: white; text-decoration: none; padding: 4px 10px; border-radius: 3px; font-size: 12px; font-weight: bold; margin-right: 4px; display: inline-block;">
                                            Detail
                                        </a>

                                        <!-- Tombol Kembalikan khusus Admin & Petugas -->
                                        @role('admin|petugas')
                                            @if($item->status == 'Dipinjam')
                                                <form action="{{ route('peminjaman.kembalikan', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" onclick="return confirm('Proses pengembalian buku ini?')" style="background: #007bff; color: white; border: none; padding: 4px 10px; cursor: pointer; border-radius: 3px; font-size: 12px; font-weight: bold;">
                                                        Kembalikan
                                                    </button>
                                                </form>
                                            @else
                                                <span style="color: gray; font-size: 12px;">Selesai</span>
                                            @endif
                                        @endrole
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="padding: 15px; text-align: center; color: #666;">
                                        Belum ada data peminjaman buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div style="margin-top: 20px;">
                        <a href="{{ route('dashboard') }}" style="color: #007bff; text-decoration: none;">← Kembali ke Dasbor</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
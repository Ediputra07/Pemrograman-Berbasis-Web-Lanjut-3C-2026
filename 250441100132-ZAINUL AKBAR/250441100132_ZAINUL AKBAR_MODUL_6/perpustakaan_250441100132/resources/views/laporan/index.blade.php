<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- RINGKASAN STATISTIK -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                    <p class="text-gray-500 text-sm font-bold">Total Transaksi</p>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $totalPeminjaman }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
                    <p class="text-gray-500 text-sm font-bold">Buku Sedang Dipinjam</p>
                    <p class="text-2xl font-extrabold text-yellow-600">{{ $totalDipinjam }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                    <p class="text-gray-500 text-sm font-bold">Buku Sudah Dikembalikan</p>
                    <p class="text-2xl font-extrabold text-green-600">{{ $totalDikembalikan }}</p>
                </div>
            </div>

            <!-- FORM FILTER TANGGAL & CETAK -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                        Filter
                    </button>
                    <a href="{{ route('laporan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow">
                        Reset
                    </a>
                    <button type="button" onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow ml-auto">
                        Cetak Laporan
                    </button>
                </form>
            </div>

            <!-- TABEL DATA LAPORAN -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border border-gray-200 text-center">No</th>
                            <th class="p-3 border border-gray-200">Nama Peminjam</th>
                            <th class="p-3 border border-gray-200">Judul Buku</th>
                            <th class="p-3 border border-gray-200 text-center">Tgl Pinjam</th>
                            <th class="p-3 border border-gray-200 text-center">Jatuh Tempo</th>
                            <th class="p-3 border border-gray-200 text-center">Tgl Dikembalikan</th> <!-- Kolom Baru -->
                            <th class="p-3 border border-gray-200 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $index => $item)
                            <tr>
                                <td class="p-3 border border-gray-200 text-center">{{ $index + 1 }}</td>
                                <td class="p-3 border border-gray-200 font-semibold">{{ $item->user->name ?? '-' }}</td>
                                <td class="p-3 border border-gray-200">{{ $item->buku->judul ?? $item->buku->judul_buku ?? '-' }}</td>
                                <td class="p-3 border border-gray-200 text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d F Y') }}
                                </td>
                                <td class="p-3 border border-gray-200 text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d F Y') }}
                                </td>
                                <!-- MENAMPILKAN TANGGAL AKTUAL PENGEMBALIAN -->
                                <td class="p-3 border border-gray-200 text-center font-bold">
                                    @if($item->status == 'Dikembalikan' && $item->tanggal_dikembalikan)
                                        <span class="text-green-700">
                                            {{ \Carbon\Carbon::parse($item->tanggal_dikembalikan)->translatedFormat('d F Y') }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic">Belum dikembalikan</span>
                                    @endif
                                </td>
                                <td class="p-3 border border-gray-200 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold {{ $item->status == 'Dipinjam' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-500">Tidak ada data transaksi peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
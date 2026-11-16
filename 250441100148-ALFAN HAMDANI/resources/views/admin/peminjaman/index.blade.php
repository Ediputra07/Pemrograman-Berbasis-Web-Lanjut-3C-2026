<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-blue-600 -m-6 p-6">
            {{ __('Kelola Peminjaman & Pengembalian - Perpustakaan Cendekia') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftar Pengajuan & Status Peminjaman Buku</h3>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                    Peminjam</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                    Judul Buku</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                    Tgl Pinjam</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                    Tgl Kembali</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                    Status</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($peminjaman as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->user->name ?? $item->anggota->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->buku->judul ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->tanggal_pinjam }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->tanggal_kembali ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 py-1 text-xs font-semibold rounded 
                                                        @if($item->status == 'Diajukan') bg-yellow-100 text-yellow-800 
                                                        @elseif($item->status == 'Dipinjam') bg-blue-100 text-blue-800 
                                                        @elseif($item->status == 'Dikembalikan') bg-green-100 text-green-800 
                                                        @else bg-red-100 text-red-800 @endif">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <!-- Jika status masih 'Diajukan', tampilkan tombol Setujui & Tolak -->
                                        @if($item->status == 'Diajukan')
                                            <form action="{{ route('admin.peminjaman.setujui', $item->id) }}" method="POST"
                                                class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="text-green-600 hover:text-green-900 mr-2 font-semibold text-xs">Setujui</button>
                                            </form>
                                            <form action="{{ route('admin.peminjaman.tolak', $item->id) }}" method="POST"
                                                class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 font-semibold text-xs">Tolak</button>
                                            </form>
                                        @endif

                                        <!-- Jika status sudah 'Dipinjam', tampilkan tombol untuk Mencatat Pengembalian -->
                                        @if($item->status == 'Dipinjam')
                                            <form action="{{ route('admin.peminjaman.kembalikan', $item->id) }}" method="POST"
                                                class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="bg-indigo-600 text-white px-3 py-1 rounded text-xs hover:bg-indigo-700"
                                                    onclick="return confirm('Catat buku ini sudah dikembalikan?')">
                                                    Proses Pengembalian
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Jika status sudah 'Dipinjam', tampilkan tombol untuk Mencatat Pengembalian -->
                                        @if($item->status == 'Dipinjam')
                                            <form action="{{ route('admin.peminjaman.kembalikan', $item->id) }}" method="POST"
                                                class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="bg-indigo-600 text-white px-3 py-1 rounded text-xs hover:bg-indigo-700"
                                                    onclick="return confirm('Catat buku ini sudah dikembalikan?')">
                                                    Proses Pengembalian
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data
                                        peminjaman buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
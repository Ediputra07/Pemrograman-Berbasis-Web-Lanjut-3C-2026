<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Data Buku Perpustakaan') }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('buku.create') }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition text-sm shadow-sm flex items-center gap-2">
                    <span>➕ Tambah Buku Baru</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm">
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tabel Daftar Buku -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📚 Daftar Buku Perpustakaan</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-sm text-sm">
                        <thead>
                            <tr class="bg-blue-50 text-left text-gray-700 uppercase font-semibold text-xs">
                                <th class="py-3 px-4 border-b">Kategori</th>
                                <th class="py-3 px-4 border-b">Judul</th>
                                <th class="py-3 px-4 border-b">Penulis</th>
                                <th class="py-3 px-4 border-b">Tahun</th>
                                <th class="py-3 px-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($bukuList as $b)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">{{ $b->kategori->nama_kategori ?? $b->kategori_id ?? '-' }}</td>
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $b->judul ?? $b->nama_buku }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $b->penulis ?? '-' }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $b->tahun_terbit ?? '-' }}</td>
                                    <td class="py-3 px-4 text-center space-x-1">
                                        <a href="{{ route('buku.edit', $b->id) }}" class="inline-block px-3 py-1 bg-amber-500 text-white rounded hover:bg-amber-600 transition text-xs font-semibold shadow-sm">
                                            Ubah
                                        </a>
                                        <form action="{{ route('buku.destroy', $b->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-xs font-semibold shadow-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500">Belum ada data buku di perpustakaan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
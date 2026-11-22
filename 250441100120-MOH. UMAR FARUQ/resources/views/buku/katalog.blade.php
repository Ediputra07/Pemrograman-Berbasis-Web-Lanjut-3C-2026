<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Buku Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📖 Daftar Katalog Buku</h3>

                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-sm text-sm">
                        <thead>
                            <tr class="bg-blue-50 text-left text-gray-700 uppercase font-semibold text-xs">
                                <th class="py-3 px-4 border-b">Kategori</th>
                                <th class="py-3 px-4 border-b">Judul Buku</th>
                                <th class="py-3 px-4 border-b">Penulis</th>
                                <th class="py-3 px-4 border-b">Tahun Terbit</th>
                                <th class="py-3 px-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($bukuList as $buku)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">{{ $buku->kategori->nama_kategori ?? $buku->kategori_id ?? '-' }}</td>
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $buku->judul }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $buku->penulis }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $buku->tahun_terbit }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <form action="{{ route('peminjaman.store') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin meminjam buku ini?');">
                                            @csrf
                                            <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                            <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-xs font-semibold shadow-sm">
                                                Pinjam Buku
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500">Belum ada buku tersedia di katalog.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
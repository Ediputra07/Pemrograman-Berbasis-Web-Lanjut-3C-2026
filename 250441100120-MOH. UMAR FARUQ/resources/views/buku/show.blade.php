<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($buku) ? $buku->judul : 'Buku Tidak Ditemukan' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                @if (isset($buku) && $buku)
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">
                        📚 Informasi Detail Buku: {{ $buku->judul }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-sm">
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase">ID Buku:</span>
                            <p class="font-medium text-gray-900 text-base mt-1">{{ $buku->id }}</p>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase">Kategori:</span>
                            <p class="font-medium text-gray-900 text-base mt-1">{{ $buku->kategori->nama_kategori ?? $buku->kategori->nama ?? $buku->kategori_id ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase">Penulis:</span>
                            <p class="font-medium text-gray-900 text-base mt-1">{{ $buku->penulis }}</p>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase">Tahun Terbit:</span>
                            <p class="font-medium text-gray-900 text-base mt-1">{{ $buku->tahun_terbit }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t">
                        <a href="{{ route('buku.index') }}" class="px-5 py-2 bg-gray-600 text-white font-semibold text-xs uppercase tracking-widest rounded-md hover:bg-gray-700 transition shadow-sm">
                            &larr; Kembali ke Daftar Buku
                        </a>
                    </div>
                @else
                    <div class="text-center py-6">
                        <h3 class="text-lg font-bold text-red-600 mb-2">Data Buku Tidak Ditemukan!</h3>
                        <p class="text-gray-600 text-sm mb-4">Buku dengan ID yang Anda cari tidak tersedia dalam sistem perpustakaan.</p>
                        <a href="{{ route('buku.index') }}" class="inline-block px-5 py-2 bg-gray-600 text-white font-semibold text-xs uppercase tracking-widest rounded-md hover:bg-gray-700 transition shadow-sm">
                            Kembali ke Daftar Buku
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
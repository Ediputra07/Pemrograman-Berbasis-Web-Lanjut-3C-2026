<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ubah Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">
                    ✏️ Edit Data Buku: {{ $buku->judul }}
                </h3>

                <form action="{{ route('buku.update', $buku->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">ID / Kategori:</label>
                            <input type="text" name="kategori_id" value="{{ old('kategori_id', $buku->kategori_id) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Judul Buku:</label>
                            <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Penulis:</label>
                            <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Tahun Terbit:</label>
                            <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-2 border-t">
                        <button type="submit" class="px-5 py-2 bg-blue-600 text-white font-semibold text-xs uppercase tracking-widest rounded-md hover:bg-blue-700 transition shadow-sm">
                            Perbarui Data
                        </button>
                        <a href="{{ route('buku.index') }}" class="px-5 py-2 bg-gray-300 text-gray-700 font-semibold text-xs uppercase tracking-widest rounded-md hover:bg-gray-400 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
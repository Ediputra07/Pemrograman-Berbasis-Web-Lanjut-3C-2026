<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Buku Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('buku.store') }}" method="POST" class="max-w-lg">
                    @csrf

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Kategori</label>
                        <select name="kategori_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategories as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Judul -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Judul Buku</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                    </div>

                    <!-- Penulis -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                    </div>

                    <!-- Penerbit -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ old('penerbit') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    </div>

                    <!-- Tahun Terbit -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('buku.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                        
                        <!-- TOMBOL SUDAH DIRUBAH DENGAN STYLE JELAS -->
                        <button type="submit" style="background-color: #28a745; color: #ffffff; padding: 8px 18px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer;">
                            Simpan Buku
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
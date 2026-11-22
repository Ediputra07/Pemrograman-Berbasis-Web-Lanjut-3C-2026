<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('buku.update', $buku->id) }}" method="POST" class="max-w-lg">
                    @csrf
                    @method('PUT')

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Kategori</label>
                        <select name="kategori_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                            @foreach($kategories as $kategori)
                                <option value="{{ $kategori->id }}" {{ $buku->kategori_id == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Judul -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Judul Buku</label>
                        <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                    </div>

                    <!-- Penulis -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                    </div>

                    <!-- Penerbit -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    </div>

                    <!-- Tahun Terbit -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-gray-700">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('buku.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow">
                            Update Buku
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
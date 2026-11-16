<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Navbar Sederhana -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Sistem Perpustakaan Digital</h1>
            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:underline font-semibold">&larr; Kembali ke Dashboard</a>
        </div>
    </nav>

    <!-- Konten Form Edit -->
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h2 class="text-xl font-bold text-gray-700 mb-6">Edit Data Buku</h2>

                <!-- Form Edit Buku -->
                <form action="{{ route('buku-crud.update', $buku->id) }}" method="POST">
                @csrf
                @method('PUT')

                    <!-- Judul Buku -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul Buku</label>
                        <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Penulis -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                
                    <!-- Tahun Terbit -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Kategori ID -->
                    <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #333;">Kategori Buku</label>
                <select name="kategori_id" required 
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; background-color: #ffffff; color: #000000;">
                    <option value="" disabled selected style="color: #6b7280;">-- Pilih Kategori Buku --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" style="color: #000000; background-color: #ffffff;">
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>


                    <!-- Tombol Aksi -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg text-sm">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-sm shadow">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>
</html>
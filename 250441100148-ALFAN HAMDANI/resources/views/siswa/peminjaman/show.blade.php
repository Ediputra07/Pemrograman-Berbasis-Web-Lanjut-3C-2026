<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-blue-600 -m-6 p-6">
            Detail Peminjaman Buku
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Informasi Detail Peminjaman</h3>

                <p><strong>ID Peminjaman:</strong> {{ $peminjaman->id }}</p>
                <p><strong>ID Anggota:</strong> {{ $peminjaman->anggota_id }}</p>
                <p><strong>ID Buku:</strong> {{ $peminjaman->buku_id }}</p>
                <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
                <p><strong>Status:</strong> {{ $peminjaman->status }}</p>

                <div class="mt-6">
                    <a href="javascript:history.back()" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
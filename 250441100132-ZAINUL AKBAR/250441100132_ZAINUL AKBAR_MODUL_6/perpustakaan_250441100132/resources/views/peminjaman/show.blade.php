<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Peminjaman #{{ $peminjaman->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-2">
                <p><strong>ID Transaksi:</strong> {{ $peminjaman->id }}</p>
                <p><strong>Nama Peminjam:</strong> {{ $peminjaman->user->name ?? '-' }} (User ID: {{ $peminjaman->user_id }})</p>
                <p><strong>Judul Buku:</strong> {{ $peminjaman->buku->judul ?? $peminjaman->buku->judul_buku ?? '-' }} (Buku ID: {{ $peminjaman->buku_id }})</p>
                <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
                <p><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_kembali }}</p>
                <p><strong>Status:</strong> {{ $peminjaman->status }}</p>

                <div style="margin-top: 20px;">
                    <a href="{{ route('peminjaman.index') }}" style="color: #007bff; text-decoration: none;">
                        ← Kembali ke Daftar Peminjaman
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
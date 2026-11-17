<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pengembalian Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4 text-sm text-green-700" role="status">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="rounded-md bg-red-50 p-4 text-sm text-red-700" role="alert">{{ session('error') }}</div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-5 text-lg font-semibold text-gray-900">Buku yang Sedang Dipinjam</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-blue-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-4 py-3">Anggota</th>
                                <th class="px-4 py-3">Buku</th>
                                <th class="px-4 py-3">Tanggal Pinjam</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($peminjamanList as $peminjaman)
                                <tr>
                                    <td class="px-4 py-3">{{ $peminjaman->anggota->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $peminjaman->buku->judul ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $peminjaman->tanggal_pinjam }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <form method="POST" action="{{ route('pengembalian.update', $peminjaman) }}" onsubmit="return confirm('Catat buku ini sudah dikembalikan?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="rounded-md bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-700">
                                                Catat Pengembalian
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">Tidak ada buku yang menunggu pengembalian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

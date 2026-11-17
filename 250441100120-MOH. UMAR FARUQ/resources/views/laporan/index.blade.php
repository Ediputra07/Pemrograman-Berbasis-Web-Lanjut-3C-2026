<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section aria-label="Ringkasan peminjaman" class="grid grid-cols-2 gap-4 lg:grid-cols-5">
                @foreach ([
                    'total' => 'Total Peminjaman',
                    'menunggu' => 'Menunggu Persetujuan',
                    'dipinjam' => 'Sedang Dipinjam',
                    'dikembalikan' => 'Dikembalikan',
                    'ditolak' => 'Ditolak',
                ] as $key => $label)
                    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                        <p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($stats[$key]) }}</p>
                    </div>
                @endforeach
            </section>

            <section class="overflow-hidden rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="mb-5 text-lg font-semibold text-gray-900">Rekap Peminjaman Buku</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-blue-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-4 py-3">Anggota</th>
                                <th class="px-4 py-3">Buku</th>
                                <th class="px-4 py-3">Tanggal Pinjam</th>
                                <th class="px-4 py-3">Tanggal Kembali</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($peminjamanList as $peminjaman)
                                <tr>
                                    <td class="px-4 py-3">{{ $peminjaman->anggota->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $peminjaman->buku->judul ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $peminjaman->tanggal_pinjam }}</td>
                                    <td class="px-4 py-3">{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $peminjaman->status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data peminjaman untuk dilaporkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>

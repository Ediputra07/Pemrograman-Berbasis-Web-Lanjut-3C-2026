<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Peminjaman Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📋 Daftar Pengajuan Peminjaman</h3>
                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700" role="status">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700" role="alert">{{ session('error') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-sm text-sm">
                        <thead>
                            <tr class="bg-blue-50 text-left text-gray-700 uppercase font-semibold text-xs">
                                <th class="py-3 px-4 border-b">Peminjam (Siswa)</th>
                                <th class="py-3 px-4 border-b">Judul Buku</th>
                                <th class="py-3 px-4 border-b">Tanggal Pinjam</th>
                                <th class="py-3 px-4 border-b text-center">Status</th>
                                <th class="py-3 px-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($peminjamanList as $p)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $p->anggota->nama ?? '-' }}</td>
                                    <td class="py-3 px-4 text-gray-700">{{ $p->buku->judul ?? '-' }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $p->tanggal_pinjam }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2 py-1 rounded text-xs font-semibold 
                                            {{ $p->status == 'Dipinjam' || $p->status == 'Dikembalikan' ? 'bg-green-100 text-green-700' : ($p->status == 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                            {{ $p->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center space-x-1">
                                        @if(in_array($p->status, ['Pending', 'Diajukan'], true))
                                            <form action="{{ route('peminjaman.setujui', $p->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-xs font-semibold shadow-sm">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('peminjaman.tolak', $p->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-xs font-semibold shadow-sm">
                                                    Tolak
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 font-medium">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500">Belum ada pengajuan peminjaman buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
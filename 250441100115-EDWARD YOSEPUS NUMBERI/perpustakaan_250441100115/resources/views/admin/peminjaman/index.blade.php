<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Peminjaman Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($peminjamans as $index => $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                            
                            <!-- Memanggil relasi 'anggota' dengan benar -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->anggota->name ?? $item->user->name ?? '-' }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->buku->judul ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->tanggal_pinjam }}</td>
                            
                            <!-- Kolom Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ strtolower($item->status) == 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $item->status ?? 'Dipinjam' }}
                                </span>
                            </td>
                            
                            <!-- Kolom Aksi / Tombol Proses Pengembalian -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    @if(empty($item->tanggal_pengembalian))
                        <!-- Tombol ini akan muncul selama tanggal pengembalian masih kosong -->
                        <form action="{{ route('admin.peminjaman.kembali', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-semibold bg-indigo-50 px-3 py-1 rounded border border-indigo-200" onclick="return confirm('Konfirmasi buku sudah dikembalikan?')">
                                Proses Pengembalian
                            </button>
                        </form>
                    @else
                        <span class="text-gray-400 italic">Selesai</span>
                    @endif
                </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
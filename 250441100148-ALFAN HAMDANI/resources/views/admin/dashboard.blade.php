<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-blue-600 -m-6 p-6">
            {{ __('Dashboard Admin - Perpustakaan Cendekia') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informasi Selamat Datang -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Selamat Datang, Administrator!</h3>
                    <p class="text-sm text-gray-600 mt-1">Anda memiliki hak akses penuh untuk mengelola sistem
                        perpustakaan, data pengguna, peran (*role*), dan laporan.</p>
                </div>
            </div>

            <!-- Kartu Navigasi / Fitur Khusus Admin -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kelola Buku -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-600">
                    <h4 class="font-bold text-gray-800 text-base">Kelola Data Buku</h4>
                    <p class="text-sm text-gray-600 mt-2">Tambah, ubah, dan hapus katalog buku perpustakaan.</p>
                    <a href="{{ route('buku.index') }}"
                        class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded shadow">
                        Kelola Buku
                    </a>
                </div>

                <!-- Kelola Peminjaman & Pengembalian -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-600">
                    <h4 class="font-bold text-gray-800 text-base">Kelola Peminjaman</h4>
                    <p class="text-sm text-gray-600 mt-2">Setujui atau tolak pengajuan peminjaman serta catat
                        pengembalian.</p>
                    <a href="{{ route('admin.peminjaman.index') }}"
                        class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded shadow">
                        Kelola Peminjaman
                    </a>
                </div>

                <!-- Kelola Pengguna & Role (Eksklusif Admin) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-purple-600">
                    <h4 class="font-bold text-gray-800 text-base">Kelola Data Pengguna</h4>
                    <p class="text-sm text-gray-600 mt-2">Kelola data akun pengguna serta penetapan role
                        (Admin/Petugas/Siswa).</p>
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-block mt-4 bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold px-4 py-2 rounded shadow">
                        Kelola Pengguna & Role
                    </a>
                </div>

                <!-- === MENU LAPORAN PERPUSTAKAAN === -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-amber-500">
                    <h4 class="font-bold text-gray-800 text-base">Laporan Perpustakaan</h4>
                    <p class="text-sm text-gray-600 mt-2">Lihat dan cetak rekapitulasi data peminjaman buku
                        perpustakaan.</p>
                    <a href="{{ route('admin.laporan.index') }}"
                        class="inline-block mt-4 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold px-4 py-2 rounded shadow">
                        Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
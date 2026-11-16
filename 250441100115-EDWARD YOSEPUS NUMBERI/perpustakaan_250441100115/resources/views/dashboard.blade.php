<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-gray-600 font-medium mb-4">Sistem buku perpustakaan sederhana</p>

                    <!-- Informasi Role Pengguna yang Sedang Login -->
                    <div class="mb-6 p-4 rounded-lg bg-blue-50 text-blue-800 border border-blue-200">
                        <strong>Peran Anda:</strong> 
                        @role('admin') 
                            <span class="bg-red-100 text-red-800 px-2.5 py-0.5 rounded font-semibold text-sm">Admin</span> 
                        @endrole
                        @role('petugas') 
                            <span class="bg-yellow-100 text-yellow-800 px-2.5 py-0.5 rounded font-semibold text-sm">Petugas</span> 
                        @endrole
                        @role('siswa') 
                            <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded font-semibold text-sm">Siswa</span> 
                        @endrole
                    </div>

                    <!-- Panel Informasi Berdasarkan Role (TAHAP 4 & 6) -->
                    @role('admin')
                        <div class="p-4 border rounded-lg bg-gray-50 border-gray-200 mb-4">
                            <h4 class="font-bold text-md mb-1 text-gray-800">Panel Administrasi (Admin)</h4>
                            <p class="text-sm text-gray-600">Anda memiliki akses penuh untuk mengelola data pengguna, penetapan role, buku, peminjaman, pengembalian, dan laporan perpustakaan.</p>
                        </div>
                    @endrole

                    @role('petugas')
                        <div class="p-4 border rounded-lg bg-gray-50 border-gray-200 mb-4">
                            <h4 class="font-bold text-md mb-1 text-gray-800">Panel Operasional (Petugas)</h4>
                            <p class="text-sm text-gray-600">Anda memiliki akses untuk mengelola data buku, persetujuan peminjaman, pengembalian buku, serta laporan perpustakaan.</p>
                        </div>
                    @endrole

                    @role('siswa')
                        <div class="p-4 border rounded-lg bg-gray-50 border-gray-200 mb-4">
                            <h4 class="font-bold text-md mb-1 text-gray-800">Layanan Siswa</h4>
                            <p class="text-sm text-gray-600">Anda dapat melihat daftar buku, mengajukan peminjaman buku, serta memantau status dan riwayat peminjaman pribadi Anda.</p>
                        </div>
                    @endrole

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
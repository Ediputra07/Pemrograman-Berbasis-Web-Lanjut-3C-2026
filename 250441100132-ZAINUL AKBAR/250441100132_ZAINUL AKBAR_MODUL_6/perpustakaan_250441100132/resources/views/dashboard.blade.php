<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Selamat datang, {{ Auth::user()->name }}!</h3>
                    <p class="mt-2">Anda login sebagai: 
                        <span class="px-2 py-1 bg-gray-200 rounded text-sm font-semibold uppercase">
                            {{ Auth::user()->roles->pluck('name')->first() ?? 'Tidak ada role' }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- TAMPILAN KHUSUS ADMIN -->
            @role('admin')
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 shadow-sm sm:rounded-lg">
                <h4 class="font-bold text-red-800 text-lg">Menu Admin</h4>
                <p class="text-red-700 mt-1 mb-3">Anda memiliki hak akses penuh ke sistem.</p>
                <div class="flex gap-2">
                    <a href="{{ route('buku.index') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center shadow">Kelola Buku</a>
                    <a href="{{ route('peminjaman.index') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center shadow">Kelola Peminjaman</a>
                    <a href="{{ route('admin.users.index') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center shadow">Kelola Akun</a>
                    
                    <!-- TOMBOL DIPERBARUI: Diarahkan ke route laporan.index -->
                    <a href="{{ route('laporan.index') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center shadow">Laporan Perpustakaan</a>
                </div>
            </div>
            @endrole

            <!-- TAMPILAN KHUSUS PETUGAS -->
            @role('petugas')
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4 shadow-sm sm:rounded-lg">
                <h4 class="font-bold text-yellow-800 text-lg">Menu Petugas</h4>
                <p class="text-yellow-700 mt-1 mb-3">Silakan kelola sirkulasi buku dan peminjaman.</p>
                <div class="flex gap-2">
                    <a href="{{ route('buku.index') }}" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded text-center shadow">Kelola Buku</a>
                    <a href="{{ route('peminjaman.index') }}" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded text-center shadow">Kelola Peminjaman</a>
                    
                    <!-- TAMBAHAN PETUGAS: Laporan Perpustakaan sesuai syarat RBAC -->
                    <a href="{{ route('laporan.index') }}" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded text-center shadow">Laporan Perpustakaan</a>
                </div>
            </div>
            @endrole

            <!-- TAMPILAN KHUSUS SISWA -->
            @role('siswa')
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 shadow-sm sm:rounded-lg">
                <h4 class="font-bold text-blue-800 text-lg">Menu Siswa</h4>
                <p class="text-blue-700 mt-1 mb-3">Lihat daftar buku yang tersedia dan riwayat peminjaman Anda.</p>
                <div class="flex gap-2">
                    <a href="{{ route('buku.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center shadow">Lihat Daftar Buku</a>
                    <a href="{{ route('peminjaman.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center shadow">Riwayat Peminjaman</a>
                </div>
            </div>
            @endrole

        </div>
    </div>
</x-app-layout>
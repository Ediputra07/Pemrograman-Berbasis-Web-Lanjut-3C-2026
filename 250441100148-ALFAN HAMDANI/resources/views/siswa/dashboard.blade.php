<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-blue-600 -m-6 p-6">
            {{ __('Dashboard Siswa - Perpustakaan Cendekia') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Kotak Sambutan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-sm text-gray-600 mt-1">Anda dapat menjelajahi katalog buku perpustakaan serta memantau
                    status peminjaman buku Anda melalui panel di bawah ini.</p>
            </div>

            <!-- Grid Kartu Menu Siswa -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Kartu 1: Katalog Buku -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-600">
                    <h4 class="font-bold text-gray-800 text-base">Katalog Buku</h4>
                    <p class="text-sm text-gray-600 mt-2">Jelajahi daftar buku perpustakaan dan ajukan peminjaman buku.
                    </p>
                    <a href="{{ route('siswa.buku') }}"
                        class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded shadow">
                        Katalog Buku
                    </a>
                </div>

                <!-- Kartu 2: Riwayat & Status Peminjaman -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-600">
                    <h4 class="font-bold text-gray-800 text-base">Riwayat & Status</h4>
                    <p class="text-sm text-gray-600 mt-2">Pantau status persetujuan peminjaman buku dan riwayat
                        peminjaman Anda.</p>
                    <a href="{{ route('siswa.riwayat') }}"
                        class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded shadow">
                        Riwayat & Status
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
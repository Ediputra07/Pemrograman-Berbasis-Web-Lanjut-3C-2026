<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-blue-600">Ruang Baca</p>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ $isAdmin ? 'Dashboard Admin' : 'Dashboard Petugas' }}
                </h2>
            </div>
            <p class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-8 sm:py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 to-indigo-700 px-6 py-7 text-white shadow-lg sm:px-8">
                <p class="text-sm font-medium text-blue-100">Selamat datang kembali,</p>
                <h1 class="mt-1 text-2xl font-bold sm:text-3xl">{{ Auth::user()->name }}</h1>
                <p class="mt-2 max-w-2xl text-sm text-blue-100 sm:text-base">
                    {{ $isStaff
                        ? 'Pantau aktivitas perpustakaan dan akses fitur pengelolaan dari satu tempat.'
                        : 'Temukan buku dan pantau status peminjamanmu dari dashboard ini.' }}
                </p>
            </section>

            @if($isStaff)
                <section aria-label="Ringkasan perpustakaan" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <a href="{{ route('buku.index') }}" class="group rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Koleksi Buku</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($stats['books']) }}</p>
                            </div>
                            <span class="rounded-lg bg-blue-50 p-3 text-blue-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 5.25A2.25 2.25 0 0 1 6.75 3H20v16.5H6.75A2.25 2.25 0 0 0 4.5 21.75m0-16.5v16.5m0-16.5H20M8.25 7.5h8.25M8.25 11.25h8.25" />
                                </svg>
                            </span>
                        </div>
                        <span class="mt-4 inline-block text-sm font-semibold text-blue-700 group-hover:underline">Kelola buku &rarr;</span>
                    </a>

                    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Anggota</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($stats['members']) }}</p>
                            </div>
                            <span class="rounded-lg bg-violet-50 p-3 text-violet-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 19.5h5v-1.25a3.75 3.75 0 0 0-5.73-3.2M16 19.5H8m8 0v-1.25c0-.7-.18-1.35-.5-1.92M8 19.5H3v-1.25a3.75 3.75 0 0 1 5.73-3.2M8 19.5v-1.25c0-.7.18-1.35.5-1.92m0 0a6 6 0 0 1 7 0M15.5 7.25a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm4.25 2a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10.5 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                </svg>
                            </span>
                        </div>
                        <p class="mt-4 text-sm text-gray-500">Terdaftar di perpustakaan</p>
                    </div>

                    <a href="{{ route('peminjaman.kelola', ['status' => 'Pending']) }}" class="group rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Menunggu Persetujuan</p>
                                <p class="mt-2 text-3xl font-bold text-amber-600">{{ number_format($stats['pendingLoans']) }}</p>
                            </div>
                            <span class="rounded-lg bg-amber-50 p-3 text-amber-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v4.5l3 1.5m6-2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </span>
                        </div>
                        <span class="mt-4 inline-block text-sm font-semibold text-amber-700 group-hover:underline">Tinjau permintaan &rarr;</span>
                    </a>

                    <a href="{{ route('peminjaman.kelola', ['status' => 'Dipinjam']) }}" class="group rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Sedang Dipinjam</p>
                                <p class="mt-2 text-3xl font-bold text-emerald-600">{{ number_format($stats['activeLoans']) }}</p>
                            </div>
                            <span class="rounded-lg bg-emerald-50 p-3 text-emerald-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13c-1.168-.776-2.754-1.253-4.5-1.253-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </span>
                        </div>
                        <span class="mt-4 inline-block text-sm font-semibold text-emerald-700 group-hover:underline">Lihat peminjaman &rarr;</span>
                    </a>
                </section>

                <section class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Akses Fitur</h3>
                        <p class="mt-1 text-sm text-gray-500">Pilih menu untuk mengelola aktivitas perpustakaan.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @can('kelola data buku')
                            <a href="{{ route('buku.index') }}" class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-blue-200 hover:shadow-md">
                                <span class="rounded-lg bg-blue-50 p-3 text-blue-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 5.25A2.25 2.25 0 0 1 6.75 3H20v16.5H6.75A2.25 2.25 0 0 0 4.5 21.75m0-16.5v16.5m0-16.5H20" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block font-semibold text-gray-900">Kelola Buku</span>
                                    <span class="mt-1 block text-sm text-gray-500">Tambah dan perbarui koleksi buku</span>
                                </span>
                            </a>
                        @endcan

                        @can('kelola role pengguna')
                            <a href="{{ route('users.roles.index') }}" class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-fuchsia-200 hover:shadow-md">
                                <span class="rounded-lg bg-fuchsia-50 p-3 text-fuchsia-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75 14.5 5l2.8-.2 1.2 2.5 2.3 1.6-.7 2.7.7 2.7-2.3 1.6-1.2 2.5-2.8-.2-2.5 1.25L9.5 18.2l-2.8.2-1.2-2.5-2.3-1.6.7-2.7-.7-2.7 2.3-1.6 1.2-2.5 2.8.2L12 3.75Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 12h5m-2.5-2.5v5" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block font-semibold text-gray-900">Kelola Role Pengguna</span>
                                    <span class="mt-1 block text-sm text-gray-500">Atur hak akses admin, petugas, dan siswa</span>
                                </span>
                            </a>
                        @endcan

                        @can('kelola pengembalian')
                            <a href="{{ route('pengembalian.index') }}" class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-emerald-200 hover:shadow-md">
                                <span class="rounded-lg bg-emerald-50 p-3 text-emerald-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 7.5h15m-15 0 3-3m-3 3 3 3m12 6h-15m15 0-3-3m3 3-3 3" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block font-semibold text-gray-900">Kelola Pengembalian</span>
                                    <span class="mt-1 block text-sm text-gray-500">Catat buku yang sudah dikembalikan</span>
                                </span>
                            </a>
                        @endcan

                        @can('lihat laporan perpustakaan')
                            <a href="{{ route('laporan.index') }}" class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-sky-200 hover:shadow-md">
                                <span class="rounded-lg bg-sky-50 p-3 text-sky-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5h15m-12-4.5v-6m4.5 6V4.5m4.5 10.5V8.25" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block font-semibold text-gray-900">Laporan Perpustakaan</span>
                                    <span class="mt-1 block text-sm text-gray-500">Lihat rekap dan status peminjaman</span>
                                </span>
                            </a>
                        @endcan

                        @role('admin|petugas')
                            <a href="{{ route('peminjaman.kelola') }}" class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-amber-200 hover:shadow-md">
                                <span class="rounded-lg bg-amber-50 p-3 text-amber-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 4.5h13.5A2.25 2.25 0 0 1 21 6.75v12A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75v-12A2.25 2.25 0 0 1 5.25 4.5Zm3 4.5h7.5m-7.5 4.5h7.5m-7.5 4.5h3" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block font-semibold text-gray-900">Kelola Peminjaman</span>
                                    <span class="mt-1 block text-sm text-gray-500">Setujui dan pantau peminjaman</span>
                                </span>
                            </a>
                        @endrole

                        @can('kelola data pengguna')
                            <a href="{{ route('users.index') }}" class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-violet-200 hover:shadow-md">
                                <span class="rounded-lg bg-violet-50 p-3 text-violet-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 4.5 1.122 9.38 9.38 0 0 0 4.5-1.122M15 19.128v-.003a6.375 6.375 0 0 0-12.75 0v.003M15 19.128v-.002a6.375 6.375 0 0 1 9-5.816M15 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Zm6 1.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block font-semibold text-gray-900">Kelola Pengguna</span>
                                    <span class="mt-1 block text-sm text-gray-500">Atur akun dan akses pengguna</span>
                                </span>
                            </a>
                        @endcan

                        @can('lihat daftar buku')
                            <a href="{{ route('buku.katalog') }}" class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-emerald-200 hover:shadow-md">
                                <span class="rounded-lg bg-emerald-50 p-3 text-emerald-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5.25A2.25 2.25 0 0 1 5.25 3H21v16.5H5.25A2.25 2.25 0 0 0 3 21.75m0-16.5v16.5m0-16.5H21M6.75 7.5h9m-9 4.5h9" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block font-semibold text-gray-900">Katalog Buku</span>
                                    <span class="mt-1 block text-sm text-gray-500">Jelajahi daftar buku perpustakaan</span>
                                </span>
                            </a>
                        @endcan

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-gray-300 hover:shadow-md">
                            <span class="rounded-lg bg-gray-100 p-3 text-gray-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                                </svg>
                            </span>
                            <span>
                                <span class="block font-semibold text-gray-900">Profil Saya</span>
                                <span class="mt-1 block text-sm text-gray-500">Perbarui informasi akun</span>
                            </span>
                        </a>
                    </div>
                </section>

                <section class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                    <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div>
                            <h3 class="font-semibold text-gray-900">Peminjaman Terbaru</h3>
                            <p class="mt-1 text-sm text-gray-500">Aktivitas peminjaman yang baru tercatat.</p>
                        </div>
                        <a href="{{ route('peminjaman.kelola') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">Lihat semua &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[700px] text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Anggota</th>
                                    <th class="px-6 py-3 font-semibold">Buku</th>
                                    <th class="px-6 py-3 font-semibold">Tanggal Pinjam</th>
                                    <th class="px-6 py-3 font-semibold">Tanggal Kembali</th>
                                    <th class="px-6 py-3 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($latestLoans as $loan)
                                    <tr class="hover:bg-slate-50">
                                        <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">{{ $loan->anggota->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 text-gray-700">{{ $loan->buku->judul ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $loan->tanggal_pinjam ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $loan->tanggal_kembali ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @php
                                                $statusClasses = [
                                                    'Diajukan' => 'bg-amber-100 text-amber-800',
                                                    'Pending' => 'bg-amber-100 text-amber-800',
                                                    'Dipinjam' => 'bg-blue-100 text-blue-800',
                                                    'Dikembalikan' => 'bg-emerald-100 text-emerald-800',
                                                    'Ditolak' => 'bg-red-100 text-red-800',
                                                ];
                                                $loanStatus = $loan->status ?? 'Belum diproses';
                                            @endphp
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses[$loanStatus] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ $loanStatus }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada data peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            @else
                <section class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <a href="{{ route('buku.katalog') }}" class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                        <p class="text-sm font-medium text-gray-500">Jelajahi koleksi</p>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">Katalog Buku</h3>
                        <span class="mt-4 inline-block text-sm font-semibold text-blue-700">Lihat katalog &rarr;</span>
                    </a>
                    <a href="{{ route('peminjaman.index') }}" class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                        <p class="text-sm font-medium text-gray-500">Pantau permintaan dan riwayat</p>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">Peminjaman Saya</h3>
                        <span class="mt-4 inline-block text-sm font-semibold text-blue-700">Lihat peminjaman &rarr;</span>
                    </a>
                </section>
            @endif
        </div>
    </div>
</x-app-layout>

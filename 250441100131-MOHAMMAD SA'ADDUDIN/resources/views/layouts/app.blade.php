<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trim($__env->yieldContent('judul', 'Ruang Baca')) }} | Ruang Baca</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="header">
        <p class="header__eyebrow">Perpustakaan</p>
        <h1>Ruang Baca</h1>
    </header>

    <nav class="navbar" aria-label="Navigasi utama">
        <a href="{{ route('home') }}">Beranda</a>

        @auth
            {{-- @role: menu berbeda untuk tiap role --}}
            @role('admin')
                <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
            @endrole
            @role('petugas')
                <a href="{{ route('petugas.dashboard') }}">Dashboard Petugas</a>
            @endrole
            @role('siswa')
                <a href="{{ route('dashboard') }}">Dashboard</a>
            @endrole

            {{-- @can: menu muncul sesuai permission (langsung atau lewat role) --}}
            @can('lihat daftar buku')
                <a href="{{ route('buku.index') }}">Daftar Buku</a>
            @endcan
            @can('melihat status peminjaman sendiri')
                <a href="{{ route('peminjaman.status') }}">Peminjaman Saya</a>
            @endcan
            @can('melihat riwayat peminjaman sendiri')
                <a href="{{ route('peminjaman.riwayat') }}">Riwayat Saya</a>
            @endcan
            @can('kelola peminjaman')
                <a href="{{ route('kelola.peminjaman.index') }}">Kelola Peminjaman</a>
            @endcan
            @can('kelola pengembalian')
                <a href="{{ route('kelola.pengembalian.index') }}">Pengembalian</a>
            @endcan
            @can('lihat laporan perpustakaan')
                <a href="{{ route('laporan.index') }}">Laporan</a>
            @endcan
            @can('kelola data pengguna')
                <a href="{{ route('admin.pengguna.index') }}">Pengguna</a>
            @endcan
            @can('lihat profil sendiri')
                <a href="{{ route('profile.edit') }}">Profil</a>
            @endcan

            <span class="navbar__spacer"></span>
            <span class="navbar__pengguna">
                {{ auth()->user()->name }}
                <small>({{ auth()->user()->getRoleNames()->first() ?? 'tanpa role' }})</small>
            </span>
            <form method="POST" action="{{ route('logout') }}" class="navbar__form">
                @csrf
                <button type="submit" class="navbar__keluar">Keluar</button>
            </form>
        @else
            <span class="navbar__spacer"></span>
            <a href="{{ route('login') }}">Masuk</a>
            <a href="{{ route('register') }}">Daftar</a>
        @endauth
    </nav>

    <main class="konten">
        @include('partials.flash')
        @yield('konten')
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Ruang Baca</p>
    </footer>
    @stack('scripts')
</body>

</html>

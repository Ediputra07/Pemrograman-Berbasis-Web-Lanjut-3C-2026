<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <a href="{{ route('buku.index') }}">Daftar Buku</a>
    </nav>

    <main class="konten">
        @yield('konten')
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Ruang Baca</p>
    </footer>
    @stack('scripts')
</body>

</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan 250441100115</title>
    
    <!-- CSRF Token: Wajib agar Fetch API (POST, PUT, DELETE) diizinkan Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Link CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Bagian Navigasi Atas -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/buku') }}">Perpustakaan 250441100115</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                <a class="nav-link active" href="{{ url('/buku') }}">Daftar Buku</a>
            </div>
        </div>
    </nav>

    <!-- Tempat Konten Utama Disisipkan dari File View Anak -->
    <main>
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
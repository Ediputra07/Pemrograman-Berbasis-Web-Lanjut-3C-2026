<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan 250441100115</title>
    
    <!-- CDN Bootstrap 5 (Untuk Layout & Component) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Styling Header Ungu Keabuan (Sesuai Gambar) */
        .header-custom {
            background-color: #555263;
            color: #ffffff;
            padding: 30px 15px;
            text-align: center;
        }

        .header-custom h1 {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .header-custom p {
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.85;
        }

        /* Styling Navbar Gelap di Tengah (Sesuai Gambar) */
        .nav-custom {
            background-color: #1a273b;
            padding: 12px 0;
            text-align: center;
        }

        .nav-custom a {
            color: #ffffff;
            text-decoration: none !important;
            margin: 0 18px;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .nav-custom a:hover {
            opacity: 0.8;
        }

        /* Card Konten Utama */
        .card-welcome {
            background-color: #ffffff;
            border-radius: 6px;
            padding: 25px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            max-width: 800px;
            margin: 35px auto;
        }
    </style>
</head>
<body>

    <!-- Header Atas -->
    <header class="header-custom">
        <h1>Perpustakaan 250441100115</h1>
        <p>Sistem Informasi Perpustakaan Sederhana</p>
    </header>

    <!-- Navigasi Tengah -->
    <nav class="nav-custom">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('buku.index') }}">Daftar Buku</a>
    </nav>

    <!-- Konten Utama -->
    <main class="container">
        @hasSection('content')
            <div class="card-welcome">
                @yield('content')
            </div>
        @else
            <div class="card-welcome">
                <h2 class="fw-bold mb-2 text-dark" style="font-size: 1.5rem;">Selamat Datang di Perpustakaan</h2>
                <p class="text-secondary mb-4" style="font-size: 0.95rem;">Sistem buku perpustakaan sederhana</p>
                <p class="mb-0 text-dark" style="font-size: 0.95rem;">
                    Gunakan menu navigasi di atas untuk melihat katalog <strong>Daftar Buku</strong> yang tersedia.
                </p>
            </div>
        @endif
    </main>

</body>
</html>
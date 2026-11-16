@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Buku - Perpustakaan Digital</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #ecfdf5;
            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #064e3b;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 30px 15px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 21px;
            font-weight: bold;
            padding: 10px 15px 35px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px;
            margin-bottom: 8px;
            border-radius: 10px;
            font-size: 15px;
            transition: 0.2s;
        }

        .menu a:hover,
        .menu a.active {
            background: #047857;
        }

        .logout {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 25px;
        }

        .logout button {
            width: 100%;
            padding: 14px;
            background: transparent;
            border: none;
            color: white;
            text-align: left;
            font-size: 15px;
            cursor: pointer;
        }

        .logout button:hover {
            background: #047857;
            border-radius: 10px;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            min-height: 85px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 15px 35px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #111827;
            text-decoration: none;
            font-weight: bold;
        }

        .user-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #d1fae5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .content {
            padding: 40px 35px;
        }

        .page-title {
            font-size: 35px;
            font-weight: bold;
            color: #064e3b;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748b;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: white;
            border: 1px solid #d1fae5;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.05);
        }

        .detail-heading {
            border-bottom: 1px solid #d1fae5;
            padding-bottom: 20px;
            margin-bottom: 22px;
        }

        .detail-heading h2 {
            color: #064e3b;
            font-size: 25px;
            margin-bottom: 8px;
        }

        .detail-heading p {
            color: #64748b;
            font-size: 14px;
        }

        .detail-item {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 15px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 15px;
            line-height: 1.5;
        }

        .detail-item strong {
            width: 140px;
            color: #064e3b;
        }

        .detail-item span {
            color: #374151;
            flex: 1;
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 25px;
        }

        .action-button {
            display: inline-block;
            padding: 12px 20px;
            background: #047857;
            color: white;
            text-decoration: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: bold;
            transition: 0.2s;
        }

        .action-button:hover {
            background: #065f46;
        }

        .back-button {
            background: #64748b;
        }

        .back-button:hover {
            background: #475569;
        }

        .not-found {
            background: white;
            border: 1px solid #d1fae5;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.05);
        }

        .not-found h2 {
            color: #064e3b;
            margin-bottom: 12px;
        }

        .not-found p {
            color: #64748b;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 15px;
            }

            .brand {
                padding: 10px 10px 18px;
                margin-bottom: 15px;
            }

            .menu {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 5px;
            }

            .menu a {
                padding: 12px;
                margin: 0;
                font-size: 13px;
            }

            .logout {
                margin-top: 15px;
                padding-top: 10px;
            }

            .topbar {
                min-height: 65px;
                padding: 12px 20px;
            }

            .content {
                padding: 25px 15px;
            }

            .page-title {
                font-size: 28px;
            }

            .detail-card {
                padding: 20px;
            }

            .detail-heading h2 {
                font-size: 21px;
            }

            .detail-item {
                flex-direction: column;
                gap: 5px;
            }

            .detail-item strong {
                width: auto;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <div class="brand">
            Perpustakaan<br>Digital
        </div>

        <nav class="menu">

            <a href="{{ route('siswa.dashboard') }}">
                Dashboard
            </a>

            <a href="{{ route('katalog-buku') }}" class="active">
                Katalog Buku
            </a>

            <a href="{{ route('siswa.peminjaman.status') }}">
                Status Peminjaman
            </a>

            <a href="{{ route('siswa.peminjaman.riwayat') }}">
                Riwayat Peminjaman
            </a>

            <a href="{{ route('profile.edit') }}">
                Profil Saya
            </a>

        </nav>

        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>

    </aside>

    <main class="main">

        <header class="topbar">
            <a href="{{ route('profile.edit') }}" class="user-profile">
                <span class="user-icon">👤</span>
                <span>{{ $user->name }} ({{ $role }})</span>
            </a>
        </header>

        <section class="content">

            <h1 class="page-title">Detail Buku</h1>

            <p class="subtitle">
                Sistem Informasi Perpustakaan Digital
            </p>

            @if ($buku)

                <div class="detail-card">

                    <div class="detail-heading">
                        <h2>{{ $buku['judul'] }}</h2>
                        <p>Informasi lengkap buku yang dipilih.</p>
                    </div>

                    <div class="detail-item">
                        <strong>ID Buku</strong>
                        <span>{{ $buku['id'] }}</span>
                    </div>

                    <div class="detail-item">
                        <strong>Judul Buku</strong>
                        <span>{{ $buku['judul'] }}</span>
                    </div>

                    <div class="detail-item">
                        <strong>Penulis</strong>
                        <span>{{ $buku['penulis'] }}</span>
                    </div>

                    <div class="detail-item">
                        <strong>Tahun Terbit</strong>
                        <span>{{ $buku['tahun'] }}</span>
                    </div>

                    <div class="detail-item">
                        <strong>Kategori</strong>
                        <span>{{ $buku['kategori'] }}</span>
                    </div>

                    <div class="button-group">

                        @if ($user->hasRole('Siswa'))
                            <a href="{{ route('siswa.peminjaman.create', $buku['id']) }}"
                               class="action-button">
                                Ajukan Peminjaman
                            </a>
                        @endif

                        <a href="{{ route('katalog-buku') }}"
                           class="action-button back-button">
                            Kembali ke Katalog
                        </a>

                    </div>

                </div>

            @else

                <div class="not-found">

                    <h2>Buku Tidak Ditemukan</h2>

                    <p>
                        Maaf, data buku yang kamu cari tidak tersedia.
                    </p>

                    <a href="{{ route('katalog-buku') }}"
                       class="action-button back-button">
                        Kembali ke Katalog Buku
                    </a>

                </div>

            @endif

        </section>

    </main>

</div>

</body>
</html>

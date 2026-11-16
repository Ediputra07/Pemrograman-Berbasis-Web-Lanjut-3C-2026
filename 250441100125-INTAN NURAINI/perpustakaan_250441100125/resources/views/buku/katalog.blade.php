
@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Katalog Buku - Perpustakaan Digital</title>

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

        /* SIDEBAR */
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

        /* KONTEN UTAMA */
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
            line-height: 1.6;
        }

        /* BANNER */
        .welcome {
            background: linear-gradient(120deg, #064e3b, #047857);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
        }

        .welcome-label {
            font-size: 13px;
            letter-spacing: 1px;
            color: #a7f3d0;
            font-weight: bold;
        }

        .welcome h2 {
            font-size: 24px;
            margin: 12px 0;
        }

        .welcome p {
            font-size: 14px;
            line-height: 1.7;
        }

        /* TABEL KATALOG */
        .table-card {
            background: white;
            border: 1px solid #d1fae5;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 18px rgba(0,0,0,0.05);
        }

        .table-header {
            padding: 22px 25px;
            border-bottom: 1px solid #d1fae5;
        }

        .table-header h2 {
            color: #064e3b;
            font-size: 21px;
            margin-bottom: 7px;
        }

        .table-header p {
            color: #64748b;
            font-size: 14px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            min-width: 650px;
        }

        thead {
            background: #ecfdf5;
            color: #064e3b;
        }

        th {
            padding: 16px 20px;
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
        }

        td {
            padding: 17px 20px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #f1f5f9;
        }

        tbody tr:hover {
            background: #f0fdf4;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .book-title {
            color: #123047;
            font-weight: bold;
        }

        .detail-button {
            display: inline-block;
            padding: 9px 14px;
            background: #065f46;
            color: white;
            text-decoration: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
            transition: 0.2s;
        }

        .detail-button:hover {
            background: #047857;
        }

        .empty-data {
            padding: 35px;
            text-align: center;
            color: #64748b;
            font-size: 15px;
        }

        /* INFORMASI */
        .information {
            margin-top: 25px;
            background: white;
            border: 1px solid #a7f3d0;
            border-radius: 15px;
            padding: 22px 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }

        .information h3 {
            color: #064e3b;
            font-size: 17px;
            margin-bottom: 8px;
        }

        .information p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        /* RESPONSIVE */
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

            .subtitle {
                font-size: 14px;
            }

            .welcome {
                padding: 22px;
            }

            .welcome h2 {
                font-size: 21px;
            }

            .table-header {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    {{-- SIDEBAR SISWA --}}
    <aside class="sidebar">

        <div class="brand">
            📖 Perpustakaan<br>Digital
        </div>

        <nav class="menu">

            <a href="{{ route('siswa.dashboard') }}"
               class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('katalog-buku') }}"
               class="{{ request()->routeIs('katalog-buku') ? 'active' : '' }}">
                📚 Katalog Buku
            </a>

            <a href="{{ route('profile.edit') }}">
                👤 Profil Saya
            </a>

        </nav>

        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">↪ Logout</button>
            </form>
        </div>

    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="main">

        <header class="topbar">
            <a href="{{ route('profile.edit') }}" class="user-profile">
                <span class="user-icon">👤</span>
                <span>{{ $user->name }} ({{ $role }}) ⌄</span>
            </a>
        </header>

        <section class="content">

            <h1 class="page-title">Katalog Buku</h1>

            <p class="subtitle">
                Sistem Informasi Perpustakaan Digital
            </p>

            {{-- BANNER SAMBUTAN --}}
            <div class="welcome">

                <span class="welcome-label">
                    PERPUSTAKAAN DIGITAL
                </span>

                <h2>
                    Selamat datang, {{ $user->name }}!
                </h2>

                <p>
                    Silakan lihat koleksi buku yang tersedia di perpustakaan.
                    Pilih buku yang ingin kamu baca dan lihat informasi
                    lengkapnya melalui tombol detail.
                </p>

            </div>

            {{-- DAFTAR BUKU --}}
            <div class="table-card">

                <div class="table-header">
                    <h2>Daftar Buku</h2>
                    <p>
                        Berikut adalah koleksi buku yang tersedia
                        di perpustakaan.
                    </p>
                </div>

                @if ($buku->isEmpty())

                    <div class="empty-data">
                        Belum ada buku yang tersedia di perpustakaan.
                    </div>

                @else

                    <div class="table-wrapper">

                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Tahun Terbit</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($buku as $index => $item)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        {{-- A1: Judul buku ditampilkan dengan escaping --}}
                                        <td class="book-title">
                                            {{$item->judul}}
                                        </td>

                                        <td>
                                            {{ $item->penulis }}
                                        </td>

                                        <td>
                                            {{ $item->kategori }}
                                        </td>

                                        <td>
                                            {{ $item->tahun_terbit }}
                                        </td>

                                        <td>
                                            <a href="{{ route('buku.detail', $item->id) }}"
                                               class="detail-button">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>

                    </div>

                @endif

            </div>

            {{-- INFORMASI --}}
            <div class="information">

                <h3>Informasi Katalog</h3>

                <p>
                    Halaman ini digunakan untuk melihat koleksi buku
                    perpustakaan. Klik tombol Lihat Detail pada buku
                    yang ingin kamu ketahui informasinya lebih lanjut.
                </p>

            </div>

        </section>

    </main>

</div>

</body>
</html>

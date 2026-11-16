<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman - Perpustakaan Digital</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
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
            padding: 30px 15px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 21px;
            font-weight: bold;
            padding: 10px 15px 35px;
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(255,255,255,.2);
            line-height: 1.5;
        }

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px;
            margin-bottom: 8px;
            border-radius: 10px;
            font-size: 14px;
        }

        .menu a:hover,
        .menu a.active {
            background: #047857;
        }

        .logout {
            margin-top: 35px;
            border-top: 1px solid rgba(255,255,255,.2);
            padding-top: 20px;
        }

        .logout button {
            width: 100%;
            padding: 14px;
            color: white;
            background: transparent;
            border: none;
            text-align: left;
            cursor: pointer;
            font-size: 14px;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            min-height: 85px;
            background: white;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 15px 35px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        .user-profile {
            color: #111827;
            text-decoration: none;
            font-weight: bold;
        }

        .content {
            padding: 35px;
        }

        .page-title {
            color: #064e3b;
            font-size: 30px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 25px;
        }

        .alert {
            padding: 14px;
            background: #d1fae5;
            color: #065f46;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #d1fae5;
            box-shadow: 0 4px 15px rgba(0,0,0,.04);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        th {
            background: #ecfdf5;
            color: #064e3b;
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            background: #fef3c7;
            color: #92400e;
            font-size: 12px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            color: #64748b;
            padding: 35px 10px;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            background: #047857;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn:hover {
            background: #065f46;
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
                padding: 10px;
                margin-bottom: 12px;
            }

            .menu {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 5px;
            }

            .menu a {
                padding: 11px;
                margin: 0;
                font-size: 13px;
            }

            .topbar {
                min-height: 65px;
                padding: 15px;
            }

            .content {
                padding: 20px 15px;
            }

            .page-title {
                font-size: 25px;
            }

            .card {
                padding: 15px;
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
            <a href="{{ route('siswa.dashboard') }}">Dashboard</a>
            <a href="{{ route('katalog-buku') }}">Katalog Buku</a>
            <a href="{{ route('siswa.peminjaman.status') }}" class="active">Status Peminjaman</a>
            <a href="{{ route('siswa.peminjaman.riwayat') }}">Riwayat Peminjaman</a>
            <a href="{{ route('profile.edit') }}">Profil Saya</a>
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
                {{ Auth::user()->name }} (Siswa)
            </a>
        </header>

        <section class="content">

            <h1 class="page-title">Status Peminjaman</h1>

            <p class="subtitle">
                Pantau pengajuan peminjaman buku yang sedang diproses.
            </p>

            @if (session('success'))
                <div class="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">

                @if ($peminjamans->count() > 0)

                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($peminjamans as $index => $peminjaman)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="status">
                                            {{ $peminjaman->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @else

                    <div class="empty">
                        <h3>Belum Ada Pengajuan Peminjaman</h3>
                        <p style="margin-top: 10px;">
                            Pengajuan peminjaman buku kamu akan muncul di halaman ini.
                        </p>

                        <a href="{{ route('katalog-buku') }}" class="btn">
                            Lihat Katalog Buku
                        </a>
                    </div>

                @endif

            </div>

        </section>

    </main>

</div>

</body>
</html>

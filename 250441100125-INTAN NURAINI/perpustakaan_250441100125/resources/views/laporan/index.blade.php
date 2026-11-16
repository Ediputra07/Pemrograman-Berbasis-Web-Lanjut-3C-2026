<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perpustakaan - Perpustakaan Digital</title>

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
            line-height: 1.4;
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

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #111827;
            text-decoration: none;
            font-weight: bold;
        }

        .admin-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .content {
            padding: 40px 35px;
        }

        .page-title {
            font-size: 38px;
            font-weight: bold;
            color: #064e3b;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748b;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: white;
            border-radius: 15px;
            padding: 23px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
            border-left: 5px solid #047857;
        }

        .summary-card h3 {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 13px;
        }

        .summary-card p {
            color: #064e3b;
            font-size: 30px;
            font-weight: bold;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 22px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            color: #123047;
            margin-bottom: 22px;
        }

        .filter-form {
            display: flex;
            align-items: end;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-group label {
            font-size: 13px;
            font-weight: bold;
            color: #374151;
        }

        .filter-group input {
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-family: Arial, sans-serif;
        }

        .btn {
            padding: 12px 18px;
            border: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-filter {
            background: #047857;
            color: white;
        }

        .btn-reset {
            background: #e5e7eb;
            color: #374151;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background: #065f46;
            color: white;
        }

        thead th {
            padding: 17px 14px;
            font-size: 14px;
            border: 1px solid #d1d5db;
        }

        tbody td {
            padding: 14px;
            border: 1px solid #e2e8f0;
            color: #26364b;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #ecfdf5;
        }

        .number {
            text-align: center;
            width: 60px;
        }

        .status {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .dipinjam {
            background: #fef0b5;
            color: #a16207;
        }

        .dikembalikan {
            background: #bbf7d0;
            color: #15803d;
        }

        .empty {
            text-align: center;
            padding: 25px;
        }

        .print-area {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 18px;
        }

        .btn-print {
            background: #064e3b;
            color: white;
        }

        @media print {
            body {
                background: white;
            }

            .sidebar,
            .topbar,
            .filter-form,
            .print-area {
                display: none !important;
            }

            .content {
                padding: 10px;
            }

            .card,
            .summary-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .table-wrapper {
                overflow: visible;
            }

            table {
                min-width: 100%;
            }
        }

        @media (max-width: 900px) {
            .summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
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
                padding-bottom: 15px;
            }

            .menu a {
                padding: 11px;
                font-size: 13px;
            }

            .topbar {
                min-height: 60px;
                padding: 12px 20px;
            }

            .content {
                padding: 25px 15px;
            }

            .page-title {
                font-size: 29px;
            }

            .subtitle {
                font-size: 15px;
            }

            .summary {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();
    $isAdmin = $user->hasRole('Admin');
    $isPetugas = $user->hasRole('Petugas');
@endphp

<div class="layout">

    {{-- SIDEBAR SESUAI ROLE --}}
    <aside class="sidebar">

        <div class="brand">
            📖 Perpustakaan<br>Digital
        </div>

        <nav class="menu">

            @if ($isAdmin)

                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('kelola-buku') }}"
                   class="{{ request()->routeIs('kelola-buku') ? 'active' : '' }}">
                    📚 Daftar Buku
                </a>

                <a href="{{ route('anggota.index') }}"
                   class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                    👥 Kelola Anggota
                </a>

                <a href="{{ route('admin.peminjaman') }}"
                   class="{{ request()->routeIs('admin.peminjaman') ? 'active' : '' }}">
                    📋 Kelola Peminjaman
                </a>

                <a href="{{ route('admin.pengembalian') }}"
                   class="{{ request()->routeIs('admin.pengembalian') ? 'active' : '' }}">
                    📥 Data Pengembalian
                </a>

                <a href="{{ route('admin.laporan') }}"
                   class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                    📊 Laporan Perpustakaan
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    👤 Profil Admin
                </a>

            @elseif ($isPetugas)

                <a href="{{ route('petugas.dashboard') }}"
                   class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('kelola-buku') }}"
                   class="{{ request()->routeIs('kelola-buku') ? 'active' : '' }}">
                    📚 Daftar Buku
                </a>

                <a href="{{ route('admin.peminjaman') }}"
                   class="{{ request()->routeIs('admin.peminjaman') ? 'active' : '' }}">
                    📋 Kelola Peminjaman
                </a>

                <a href="{{ route('admin.pengembalian') }}"
                   class="{{ request()->routeIs('admin.pengembalian') ? 'active' : '' }}">
                    📥 Data Pengembalian
                </a>

                <a href="{{ route('admin.laporan') }}"
                   class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                    📊 Laporan Perpustakaan
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    👤 Profil Petugas
                </a>

            @endif

        </nav>

        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    ↪ Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="main">

        <header class="topbar">
            <a href="{{ route('profile.edit') }}" class="admin-profile">
                <span class="admin-icon">👤</span>
                <span>{{ $user->name }} ({{ $role }}) ⌄</span>
            </a>
        </header>

        <section class="content">

            <h1 class="page-title">
                Laporan Perpustakaan
            </h1>

            <p class="subtitle">
                Ringkasan dan laporan aktivitas peminjaman serta pengembalian buku
            </p>

            {{-- RINGKASAN --}}
            <div class="summary">

                <div class="summary-card">
                    <h3>Total Peminjaman</h3>
                    <p>{{ $totalPeminjaman }}</p>
                </div>

                <div class="summary-card">
                    <h3>Total Pengembalian</h3>
                    <p>{{ $totalPengembalian }}</p>
                </div>

                <div class="summary-card">
                    <h3>Belum Dikembalikan</h3>
                    <p>{{ $belumDikembalikan }}</p>
                </div>

            </div>

            {{-- TABEL LAPORAN --}}
            <div class="card">

                <h2 class="card-title">
                    📊 Laporan Peminjaman Buku
                </h2>

                {{-- FILTER TANGGAL --}}
                <form method="GET"
                      action="{{ route('admin.laporan') }}"
                      class="filter-form">

                    <div class="filter-group">
                        <label for="tanggal_mulai">Dari Tanggal</label>
                        <input type="date"
                               id="tanggal_mulai"
                               name="tanggal_mulai"
                               value="{{ $tanggalMulai }}">
                    </div>

                    <div class="filter-group">
                        <label for="tanggal_selesai">Sampai Tanggal</label>
                        <input type="date"
                               id="tanggal_selesai"
                               name="tanggal_selesai"
                               value="{{ $tanggalSelesai }}">
                    </div>

                    <button type="submit" class="btn btn-filter">
                        Tampilkan
                    </button>

                    <a href="{{ route('admin.laporan') }}"
                       class="btn btn-reset">
                        Reset
                    </a>

                </form>

                <div class="print-area">
                    <button onclick="window.print()" class="btn btn-print">
                        Cetak Laporan
                    </button>
                </div>

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th class="number">No.</th>
                                <th>Nama Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($peminjamans as $peminjaman)

                                <tr>
                                    <td class="number">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $peminjaman->anggota->nama ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $peminjaman->buku->judul ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $peminjaman->tanggal_pinjam ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $peminjaman->tanggal_kembali ?? '-' }}
                                    </td>

                                    <td>
                                        @if ($peminjaman->tanggal_kembali)
                                            <span class="status dikembalikan">
                                                Sudah Dikembalikan
                                            </span>
                                        @else
                                            <span class="status dipinjam">
                                                Belum Dikembalikan
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="empty">
                                        Belum ada data laporan peminjaman.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</div>

</body>
</html>

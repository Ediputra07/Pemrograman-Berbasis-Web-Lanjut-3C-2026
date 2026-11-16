@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();

    $isAdmin = $user->hasRole('Admin');
    $isPetugas = $user->hasRole('Petugas');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman - Perpustakaan Digital</title>

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
            margin-bottom: 25px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1050px;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background: #065f46;
            color: white;
        }

        thead th {
            padding: 18px 15px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #d1d5db;
        }

        tbody td {
            padding: 15px;
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
            padding: 9px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .menunggu {
            background: #fef3c7;
            color: #92400e;
        }

        .disetujui {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .ditolak {
            background: #fee2e2;
            color: #b91c1c;
        }

        .dikembalikan {
            background: #bbf7d0;
            color: #15803d;
        }

        .action {
            display: flex;
            gap: 7px;
        }

        .action form {
            display: inline;
        }

        .btn {
            border: none;
            border-radius: 7px;
            padding: 9px 12px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            color: white;
        }

        .btn-setuju {
            background: #059669;
        }

        .btn-setuju:hover {
            background: #047857;
        }

        .btn-tolak {
            background: #dc2626;
        }

        .btn-tolak:hover {
            background: #b91c1c;
        }

        .processed {
            color: #64748b;
            font-size: 12px;
            font-weight: bold;
        }

        .alert {
            padding: 15px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            text-align: center;
            padding: 25px;
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
            📖 Perpustakaan<br>Digital
        </div>

        <nav class="menu">

            @if($isAdmin)

                <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
                <a href="{{ route('kelola-buku') }}">📚 Daftar Buku</a>
                <a href="{{ route('anggota.index') }}">👥 Kelola Anggota</a>
                <a href="{{ route('admin.peminjaman') }}" class="active">📋 Kelola Peminjaman</a>
                <a href="{{ route('admin.pengembalian') }}">📥 Data Pengembalian</a>
                <a href="{{ route('admin.laporan') }}">📊 Laporan Perpustakaan</a>
                <a href="{{ route('profile.edit') }}">👤 Profil Admin</a>

            @elseif($isPetugas)

                <a href="{{ route('petugas.dashboard') }}">🏠 Dashboard</a>
                <a href="{{ route('kelola-buku') }}">📚 Daftar Buku</a>
                <a href="{{ route('admin.peminjaman') }}" class="active">📋 Kelola Peminjaman</a>
                <a href="{{ route('admin.pengembalian') }}">📥 Data Pengembalian</a>
                <a href="{{ route('admin.laporan') }}">📊 Laporan Perpustakaan</a>
                <a href="{{ route('profile.edit') }}">👤 Profil Petugas</a>

            @endif

        </nav>

        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">↪ Logout</button>
            </form>
        </div>

    </aside>

    <main class="main">

        <header class="topbar">
            <a href="{{ route('profile.edit') }}" class="admin-profile">
                <span class="admin-icon">👤</span>
                <span>{{ $user->name }} ({{ $role }}) ⌄</span>
            </a>
        </header>

        <section class="content">

            <h1 class="page-title">Data Peminjaman</h1>

            <p class="subtitle">
                Kelola pengajuan peminjaman dan pengembalian buku
            </p>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">

                <h2 class="card-title">
                    📚 Daftar Peminjaman Buku
                </h2>

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
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($peminjamans as $peminjaman)

                                @php
                                    $status = $peminjaman->status ?? 'Disetujui';
                                @endphp

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
                                        {{ $peminjaman->tanggal_pinjam }}
                                    </td>

                                    <td>
                                        {{ $peminjaman->tanggal_kembali ?? '-' }}
                                    </td>

                                    <td>
                                        @if($peminjaman->tanggal_kembali)
                                            <span class="status dikembalikan">
                                                Sudah Dikembalikan
                                            </span>
                                        @elseif($status === 'Menunggu')
                                            <span class="status menunggu">
                                                Menunggu Konfirmasi
                                            </span>
                                        @elseif($status === 'Disetujui')
                                            <span class="status disetujui">
                                                Disetujui
                                            </span>
                                        @elseif($status === 'Ditolak')
                                            <span class="status ditolak">
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="status menunggu">
                                                {{ $status }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($status === 'Menunggu' && !$peminjaman->tanggal_kembali)

                                            <div class="action">

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.peminjaman.status', $peminjaman->id) }}"
                                                    onsubmit="return confirm('Setujui pengajuan peminjaman ini?')"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="Disetujui"
                                                    >

                                                    <button type="submit" class="btn btn-setuju">
                                                        Setujui
                                                    </button>
                                                </form>

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.peminjaman.status', $peminjaman->id) }}"
                                                    onsubmit="return confirm('Tolak pengajuan peminjaman ini?')"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="Ditolak"
                                                    >

                                                    <button type="submit" class="btn btn-tolak">
                                                        Tolak
                                                    </button>
                                                </form>

                                            </div>

                                        @else
                                            <span class="processed">
                                                Sudah diproses
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="empty">
                                        Belum ada data peminjaman.
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

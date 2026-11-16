@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();

    $jumlahPetugas = \App\Models\User::role('Petugas')->count();
    $jumlahSiswa = \App\Models\User::role('Siswa')->count();
    $jumlahAnggota = $jumlahPetugas + $jumlahSiswa;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard {{ $role }} - Perpustakaan Digital</title>

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
            font-size: 38px;
            font-weight: bold;
            color: #064e3b;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748b;
            font-size: 17px;
            margin-bottom: 30px;
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
            font-size: 25px;
            margin: 12px 0;
        }

        .welcome p {
            font-size: 14px;
            line-height: 1.7;
        }

        .role-label {
            display: inline-block;
            margin-top: 15px;
            padding: 9px 16px;
            border-radius: 30px;
            background: rgba(255,255,255,0.15);
            font-size: 13px;
            font-weight: bold;
        }

        /* STATISTIK ADMIN */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.06);
            border: 1px solid #d1fae5;
            transition: 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.09);
        }

        .stat-icon {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: #d1fae5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            flex-shrink: 0;
        }

        .stat-info p {
            color: #64748b;
            font-size: 14px;
            font-weight: bold;
        }

        .stat-info h3 {
            color: #064e3b;
            font-size: 32px;
            margin-top: 5px;
        }

        /* MENU */
        .section-heading {
            margin-bottom: 20px;
            border-left: 5px solid #047857;
            padding-left: 15px;
        }

        .section-heading h2 {
            font-size: 25px;
            color: #064e3b;
            margin-bottom: 7px;
        }

        .section-heading p {
            font-size: 14px;
            color: #64748b;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .menu-card {
            background: white;
            border: 1px solid #d1fae5;
            border-radius: 15px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: 0.2s;
        }

        .menu-card:hover {
            transform: translateY(-3px);
            border-color: #6ee7b7;
            box-shadow: 0 8px 20px rgba(0,0,0,0.09);
        }

        .menu-icon {
            width: 65px;
            height: 65px;
            flex-shrink: 0;
            border-radius: 14px;
            background: #d1fae5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .menu-info {
            flex: 1;
            min-width: 0;
        }

        .menu-info h3 {
            color: #123047;
            font-size: 17px;
            margin-bottom: 8px;
        }

        .menu-info p {
            color: #64748b;
            font-size: 13px;
            line-height: 1.5;
        }

        .arrow {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #d1fae5;
            color: #047857;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
        }

        /* INFORMASI AKUN */
        .information {
            margin-top: 30px;
            background: white;
            border: 1px solid #a7f3d0;
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .information h3 {
            color: #064e3b;
            font-size: 19px;
            margin-bottom: 8px;
        }

        .information p {
            color: #64748b;
            font-size: 14px;
        }

        .profile-button {
            display: inline-block;
            background: #065f46;
            color: white;
            text-decoration: none;
            padding: 13px 20px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
        }

        .profile-button:hover {
            background: #064e3b;
        }

        /* RESPONSIVE */
        @media (max-width: 1000px) {
            .sidebar {
                width: 220px;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .menu-grid {
                grid-template-columns: 1fr;
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
                font-size: 29px;
            }

            .subtitle {
                font-size: 15px;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stat-card {
                padding: 18px;
            }

            .menu-card {
                padding: 17px;
            }

            .information {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 400px) {
            .menu-card {
                gap: 10px;
                padding: 13px;
            }

            .menu-icon {
                width: 48px;
                height: 48px;
                font-size: 23px;
            }

            .menu-info h3 {
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="brand">
            📖 Perpustakaan<br>Digital
        </div>

        <nav class="menu">

            {{-- MENU ADMIN --}}
            @if($user->hasRole('Admin'))

                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('kelola-buku') }}">
                    📚 Daftar Buku
                </a>

                <a href="{{ route('anggota.index') }}">
                    👥 Kelola Anggota
                </a>

                <a href="{{ route('admin.peminjaman') }}">
                    📋 Kelola Peminjaman
                </a>

                <a href="{{ route('admin.pengembalian') }}">
                    📥 Data Pengembalian
                </a>

                <a href="{{ route('admin.laporan') }}"
                   class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                    📊 Laporan Perpustakaan
                </a>

            {{-- MENU PETUGAS --}}
            @elseif($user->hasRole('Petugas'))

                <a href="{{ route('petugas.dashboard') }}"
                   class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('kelola-buku') }}">
                    📚 Daftar Buku
                </a>

                <a href="{{ route('admin.peminjaman') }}">
                    📋 Kelola Peminjaman
                </a>

                <a href="{{ route('admin.pengembalian') }}">
                    📥 Data Pengembalian
                </a>

                <a href="{{ route('admin.laporan') }}"
                   class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                    📊 Laporan Perpustakaan
                </a>

            {{-- MENU SISWA --}}
            @elseif($user->hasRole('Siswa'))

                <a href="{{ route('siswa.dashboard') }}"
                   class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('katalog-buku') }}"
                   class="{{ request()->routeIs('katalog-buku') ? 'active' : '' }}">
                    📚 Katalog Buku
                </a>

                <a href="{{ route('siswa.peminjaman.status') }}"
                   class="{{ request()->routeIs('siswa.peminjaman.status') ? 'active' : '' }}">
                    📋 Status Peminjaman
                </a>

                <a href="{{ route('siswa.peminjaman.riwayat') }}"
                   class="{{ request()->routeIs('siswa.peminjaman.riwayat') ? 'active' : '' }}">
                    📖 Riwayat Peminjaman
                </a>

            @endif

            {{-- PROFIL SEMUA ROLE --}}
            <a href="{{ route('profile.edit') }}"
               class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
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

            <h1 class="page-title">
                Dashboard {{ $role }}
            </h1>

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

                @if($user->hasRole('Admin'))
                    <p>
                        Kelola perpustakaan dengan mudah dan efisien.
                        Gunakan menu yang tersedia untuk mengelola data
                        dan kegiatan perpustakaan.
                    </p>
                @elseif($user->hasRole('Petugas'))
                    <p>
                        Selamat bekerja. Gunakan menu yang tersedia untuk
                        mengelola buku, peminjaman, pengembalian, dan
                        laporan perpustakaan.
                    </p>
                @else
                    <p>
                        Selamat datang di Perpustakaan Digital.
                        Temukan dan lihat koleksi buku yang tersedia
                        untuk mendukung kegiatan belajar Anda.
                    </p>
                @endif

                <span class="role-label">
                    Role: {{ $role }}
                </span>

            </div>

            {{-- STATISTIK KHUSUS ADMIN --}}
            @if($user->hasRole('Admin'))

                <div class="stats">

                    <div class="stat-card">
                        <div class="stat-icon">👥</div>
                        <div class="stat-info">
                            <p>Total Anggota</p>
                            <h3>{{ $jumlahAnggota }}</h3>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">🧑‍💼</div>
                        <div class="stat-info">
                            <p>Petugas</p>
                            <h3>{{ $jumlahPetugas }}</h3>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">🎓</div>
                        <div class="stat-info">
                            <p>Siswa</p>
                            <h3>{{ $jumlahSiswa }}</h3>
                        </div>
                    </div>

                </div>

            @endif

            {{-- JUDUL MENU --}}
            <div class="section-heading">

                <h2>Menu Utama</h2>

                @if($user->hasRole('Admin'))
                    <p>Akses cepat ke fitur utama sistem.</p>
                @elseif($user->hasRole('Petugas'))
                    <p>Akses cepat ke fitur pengelolaan perpustakaan.</p>
                @else
                    <p>Akses cepat ke layanan perpustakaan.</p>
                @endif

            </div>

            <div class="menu-grid">

                {{-- MENU ADMIN --}}
                @if($user->hasRole('Admin'))

                    <a href="{{ route('kelola-buku') }}" class="menu-card">
                        <div class="menu-icon">📚</div>
                        <div class="menu-info">
                            <h3>Daftar Buku</h3>
                            <p>Mengelola data buku yang tersedia di perpustakaan.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('anggota.index') }}" class="menu-card">
                        <div class="menu-icon">👥</div>
                        <div class="menu-info">
                            <h3>Kelola Anggota</h3>
                            <p>Mengelola data pengguna perpustakaan.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('admin.peminjaman') }}" class="menu-card">
                        <div class="menu-icon">📋</div>
                        <div class="menu-info">
                            <h3>Kelola Peminjaman</h3>
                            <p>Mengelola data peminjaman buku perpustakaan.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('admin.pengembalian') }}" class="menu-card">
                        <div class="menu-icon">📥</div>
                        <div class="menu-info">
                            <h3>Data Pengembalian</h3>
                            <p>Mengelola dan memantau pengembalian buku.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('admin.laporan') }}" class="menu-card">
                        <div class="menu-icon">📊</div>
                        <div class="menu-info">
                            <h3>Laporan Perpustakaan</h3>
                            <p>Melihat ringkasan laporan peminjaman dan pengembalian buku.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="menu-card">
                        <div class="menu-icon">👤</div>
                        <div class="menu-info">
                            <h3>Profil Admin</h3>
                            <p>Mengatur informasi profil akun Anda.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                {{-- MENU PETUGAS --}}
                @elseif($user->hasRole('Petugas'))

                    <a href="{{ route('kelola-buku') }}" class="menu-card">
                        <div class="menu-icon">📚</div>
                        <div class="menu-info">
                            <h3>Daftar Buku</h3>
                            <p>Melihat dan mengelola data buku perpustakaan.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('admin.peminjaman') }}" class="menu-card">
                        <div class="menu-icon">📋</div>
                        <div class="menu-info">
                            <h3>Kelola Peminjaman</h3>
                            <p>Mengelola data dan kegiatan peminjaman buku.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('admin.pengembalian') }}" class="menu-card">
                        <div class="menu-icon">📥</div>
                        <div class="menu-info">
                            <h3>Data Pengembalian</h3>
                            <p>Mengelola dan mencatat pengembalian buku.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('admin.laporan') }}" class="menu-card">
                        <div class="menu-icon">📊</div>
                        <div class="menu-info">
                            <h3>Laporan Perpustakaan</h3>
                            <p>Melihat laporan kegiatan perpustakaan.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="menu-card">
                        <div class="menu-icon">👤</div>
                        <div class="menu-info">
                            <h3>Profil Petugas</h3>
                            <p>Mengatur informasi profil akun Anda.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                {{-- MENU SISWA --}}
                @elseif($user->hasRole('Siswa'))

                    <a href="{{ route('katalog-buku') }}" class="menu-card">
                        <div class="menu-icon">📚</div>
                        <div class="menu-info">
                            <h3>Katalog Buku</h3>
                            <p>Melihat koleksi buku yang tersedia di perpustakaan.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('siswa.peminjaman.status') }}" class="menu-card">
                        <div class="menu-icon">📋</div>
                        <div class="menu-info">
                            <h3>Status Peminjaman</h3>
                            <p>Melihat status pengajuan peminjaman buku.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('siswa.peminjaman.riwayat') }}" class="menu-card">
                        <div class="menu-icon">📖</div>
                        <div class="menu-info">
                            <h3>Riwayat Peminjaman</h3>
                            <p>Melihat seluruh catatan peminjaman buku.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="menu-card">
                        <div class="menu-icon">👤</div>
                        <div class="menu-info">
                            <h3>Profil Saya</h3>
                            <p>Melihat dan memperbarui informasi akun.</p>
                        </div>
                        <div class="arrow">→</div>
                    </a>

                @endif

            </div>

            {{-- INFORMASI AKUN --}}
            <div class="information">

                <div>
                    <h3>Informasi Akun</h3>
                    <p>
                        Perbarui informasi pribadi dan pengaturan akun Anda.
                    </p>
                </div>

                <a href="{{ route('profile.edit') }}" class="profile-button">
                    Lihat Profil →
                </a>

            </div>

        </section>

    </main>

</div>

</body>
</html>

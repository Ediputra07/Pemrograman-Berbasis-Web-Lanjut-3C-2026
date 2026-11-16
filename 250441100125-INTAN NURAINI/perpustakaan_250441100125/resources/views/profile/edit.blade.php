 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - Perpustakaan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
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
            min-height: 100vh;
            background: #064e3b;
            color: white;
            padding: 25px 18px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 21px;
            font-weight: bold;
            text-align: center;
            padding: 8px 0 30px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            margin-bottom: 25px;
        }

        .menu-title {
            font-size: 11px;
            color: #a7f3d0;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 12px 10px;
        }

        .sidebar a {
            display: block;
            text-decoration: none;
            color: #d1fae5;
            padding: 12px 14px;
            margin-bottom: 6px;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #047857;
            color: white;
        }

        /* KONTEN */
        .main-content {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            height: 70px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .topbar h1 {
            font-size: 19px;
            color: #064e3b;
            margin: 0;
        }

        .user-info {
            font-size: 14px;
            color: #475569;
        }

        .content {
            padding: 30px 35px;
        }

        .page-heading {
            margin-bottom: 25px;
        }

        .page-heading h2 {
            color: #064e3b;
            font-size: 24px;
            margin: 0 0 8px;
        }

        .page-heading p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        /* KARTU PROFIL */
        .profile-card {
            background: white;
            border-radius: 12px;
            padding: 28px;
            margin-bottom: 22px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04);
            border: 1px solid #d1fae5;
        }

        .profile-section {
            width: 100%;
        }

        .profile-header {
            margin-bottom: 25px;
        }

        .profile-header h2 {
            color: #064e3b;
            font-size: 19px;
            font-weight: 700;
            margin: 0 0 8px;
        }

        .profile-header p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
        }

        .profile-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .profile-form .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .profile-form label {
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        .profile-form input {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
        }

        .profile-form input:focus {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5,150,105,0.12);
        }

        .form-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 4px;
        }

        /* TOMBOL */
        .profile-card button {
            cursor: pointer;
        }

        .profile-card button[type="submit"] {
            border-radius: 8px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
                padding: 15px;
            }

            .brand {
                padding-bottom: 15px;
                margin-bottom: 15px;
            }

            .sidebar a {
                display: inline-block;
                margin: 3px;
            }

            .menu-title {
                margin-top: 12px;
            }

            .topbar {
                padding: 0 18px;
                height: 60px;
            }

            .topbar h1 {
                font-size: 16px;
            }

            .user-info {
                font-size: 12px;
            }

            .content {
                padding: 22px 15px;
            }

            .profile-card {
                padding: 20px;
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
    $isSiswa = $user->hasRole('Siswa');
@endphp

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="brand">
            PERPUSTAKAAN
        </div>

        <div class="menu-title">Menu Utama</div>

        @if ($isAdmin)

            <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
            <a href="{{ route('kelola-buku') }}">Daftar Buku</a>
            <a href="{{ route('anggota.index') }}">Kelola Anggota</a>
            <a href="{{ route('admin.peminjaman') }}">Peminjaman</a>
            <a href="{{ route('admin.pengembalian') }}">Pengembalian</a>
            <a href="{{ route('admin.laporan') }}">Laporan</a>

        @elseif ($isPetugas)

            <a href="{{ route('petugas.dashboard') }}">Dashboard Petugas</a>
            <a href="{{ route('kelola-buku') }}">Daftar Buku</a>
            <a href="{{ route('admin.peminjaman') }}">Peminjaman</a>
            <a href="{{ route('admin.pengembalian') }}">Pengembalian</a>
            <a href="{{ route('admin.laporan') }}">Laporan</a>

        @elseif ($isSiswa)

            <a href="{{ route('siswa.dashboard') }}">Dashboard Siswa</a>
            <a href="{{ route('katalog-buku') }}">Katalog Buku</a>

        @endif

        <div class="menu-title">Akun</div>

        <a href="{{ route('profile.edit') }}" class="active">
            Profil {{ $role }}
        </a>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="main-content">

        <header class="topbar">
            <h1>Profil Pengguna</h1>

            <div class="user-info">
                {{ $user->name }} ({{ $role }})
            </div>
        </header>

        <div class="content">

            <div class="page-heading">
                <h2>Pengaturan Profil</h2>
                <p>Kelola informasi pribadi dan keamanan akun Anda.</p>
            </div>

            <!-- INFORMASI PROFIL -->
            <div class="profile-card">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- KEAMANAN AKUN -->
            <div class="profile-card">
                @include('profile.partials.update-password-form')
            </div>

            <!-- HAPUS AKUN -->
            <div class="profile-card">
                @include('profile.partials.delete-user-form')
            </div>

        </div>

    </main>

</div>

</body>
</html>
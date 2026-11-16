<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman Buku</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #ecfdf5;
            color: #1f2937;
        }

        .sidebar {
            width: 245px;
            background: #064e3b;
            color: white;
            padding: 28px 18px;
        }

        .sidebar h2 {
            font-size: 21px;
            margin-bottom: 35px;
            padding-left: 10px;
        }

        .sidebar a {
            display: block;
            color: #d1fae5;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #047857;
            color: white;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 22px 30px;
            display: flex;
            justify-content: flex-end;
            border-bottom: 1px solid #d1fae5;
        }

        .content {
            padding: 35px;
        }

        .content h1 {
            color: #064e3b;
            margin-bottom: 10px;
            font-size: 26px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 12px;
            max-width: 650px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
        }

        .book-info {
            background: #ecfdf5;
            padding: 18px;
            border-radius: 8px;
            margin-bottom: 22px;
        }

        .book-info p {
            margin: 9px 0;
        }

        .label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #374151;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            border: none;
            padding: 12px 18px;
            border-radius: 7px;
            background: #047857;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn:hover {
            background: #065f46;
        }

        .btn-back {
            background: #64748b;
            margin-left: 7px;
        }

        .alert {
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 18px;
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        @media (max-width: 700px) {
            body {
                display: block;
            }

            .sidebar {
                width: 100%;
                padding: 15px;
            }

            .sidebar h2 {
                margin-bottom: 12px;
            }

            .sidebar a {
                display: inline-block;
                padding: 9px;
                margin: 3px;
            }

            .content {
                padding: 20px;
            }

            .topbar {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<aside class="sidebar">
    <h2>Perpustakaan</h2>

    <a href="{{ route('siswa.dashboard') }}">Dashboard</a>
    <a href="{{ route('katalog-buku') }}">Katalog Buku</a>
    <a href="{{ route('siswa.peminjaman.status') }}">Status Peminjaman</a>
    <a href="{{ route('siswa.peminjaman.riwayat') }}">Riwayat Peminjaman</a>
    <a href="{{ route('profile.edit') }}">Profil Saya</a>
</aside>

<main class="main">

    <header class="topbar">
        {{ Auth::user()->name }} (Siswa)
    </header>

    <section class="content">
        <h1>Ajukan Peminjaman Buku</h1>
        <p class="subtitle">Periksa informasi buku sebelum mengirim pengajuan.</p>

        <div class="card">

            @if (session('error'))
                <div class="alert">{{ session('error') }}</div>
            @endif

            <div class="book-info">
                <p><strong>Judul Buku:</strong> {{ $buku->judul }}</p>
                <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
            </div>

            <p style="margin-bottom: 20px;">
                Pengajuan akan dikirim kepada Admin atau Petugas untuk diproses.
            </p>

            <form method="POST"
                action="{{ route('siswa.peminjaman.store', $buku->id) }}">
                @csrf

                <button type="submit" class="btn"
                    onclick="return confirm('Yakin ingin mengajukan peminjaman buku ini?')">
                    Kirim Pengajuan
                </button>

                <a href="{{ route('katalog-buku') }}" class="btn btn-back">
                    Batal
                </a>
            </form>

        </div>
    </section>
</main>

</body>
</html>
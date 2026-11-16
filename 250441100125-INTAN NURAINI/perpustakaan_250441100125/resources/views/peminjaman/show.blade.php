<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman - Perpustakaan Digital</title>

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
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 750px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
        }

        h1 {
            color: #064e3b;
            margin-bottom: 10px;
            font-size: 30px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 30px;
        }

        .detail {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 18px;
        }

        .label {
            color: #64748b;
            font-weight: bold;
        }

        .value {
            color: #1f2937;
        }

        .back {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 18px;
            background: #047857;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .back:hover {
            background: #065f46;
        }

        @media (max-width: 600px) {
            .detail {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .value {
                margin-bottom: 12px;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <div class="card">

        <h1>Detail Peminjaman</h1>

        <p class="subtitle">
            Informasi lengkap data peminjaman buku.
        </p>

        <div class="detail">

            <div class="label">ID Peminjaman</div>
            <div class="value">{{ $peminjaman->id }}</div>

            <div class="label">Nama Peminjam</div>
            <div class="value">{{ $peminjaman->anggota->nama ?? '-' }}</div>

            <div class="label">Judul Buku</div>
            <div class="value">{{ $peminjaman->buku->judul ?? '-' }}</div>

            <div class="label">Tanggal Pinjam</div>
            <div class="value">{{ $peminjaman->tanggal_pinjam ?? '-' }}</div>

            <div class="label">Tanggal Kembali</div>
            <div class="value">{{ $peminjaman->tanggal_kembali ?? '-' }}</div>

            <div class="label">Status</div>
            <div class="value">{{ $peminjaman->status ?? '-' }}</div>

        </div>

        <a href="{{ url()->previous() }}" class="back">
            Kembali
        </a>

    </div>
</div>

</body>
</html>

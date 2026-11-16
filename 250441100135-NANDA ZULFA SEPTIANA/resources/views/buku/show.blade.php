<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Buku - Siswa</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px;">
    
    <div style="max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        
        <a href="{{ route('siswa.dashboard') }}" style="color: #4f46e5; text-decoration: none; font-weight: bold; font-size: 14px;">&larr; Kembali ke Katalog Buku</a>

        <h2 style="margin: 20px 0 10px 0; color: #1f2937;">{{ $buku->judul }}</h2>
        
        <p style="margin: 8px 0; color: #4b5563; font-size: 15px;"><strong>Penulis:</strong> {{ $buku->penulis }}</p>
        <p style="margin: 8px 0; color: #4b5563; font-size: 15px;"><strong>Penerbit:</strong> {{ $buku->penerbit ?? '-' }}</p>
        <p style="margin: 8px 0 20px 0; color: #4b5563; font-size: 15px;"><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>

        <!-- Form Ajukan Peminjaman Buku (Khusus Siswa) -->
        @role('siswa')
            <form action="{{ route('buku.pinjam', $buku->id) }}" method="POST">
                @csrf
                <button type="submit" style="background: #10b981; color: white; border: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px;">
                    Ajukan Peminjaman Buku Ini
                </button>
            </form>
        @endrole

    </div>

</body>
</html>

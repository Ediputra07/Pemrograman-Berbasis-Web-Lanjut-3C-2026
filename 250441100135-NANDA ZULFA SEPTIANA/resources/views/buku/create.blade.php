<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Perpustakaan Digital</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px;">

    <!-- Navbar Atas -->
    <div style="background: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; max-width: 600px; margin: 0 auto 20px auto;">
        <h2 style="margin: 0; font-size: 18px; color: #333;">Tambah Buku Baru</h2>
        <a href="/dashboard" style="color: #4f46e5; text-decoration: none; font-weight: bold; padding: 5px 10px; display: inline-block;">&larr; Kembali</a>
    </div>

    <!-- Kotak Form Utama -->
    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
        
        <!-- Form mengarah ke route store -->
        <form action="{{ route('buku-crud.store') }}" method="POST">
            @csrf

            <!-- Judul Buku -->
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #333;">Judul Buku</label>
                <input type="text" name="judul" value="{{ old('judul') }}" required minlength="3" placeholder="Minimal 3 karakter..."
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <!-- Penulis -->
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #333;">Penulis</label>
                <input type="text" name="penulis" value="{{ old('penulis') }}" required minlength="3" placeholder="Minimal 3 karakter..."
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <!-- Tahun Terbit -->
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #333;">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required max="2026" placeholder="Maksimal tahun 2026"
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <!-- Kategori Buku -->
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #333;">Kategori Buku</label>
                <select name="kategori_id" required 
                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; background-color: #ffffff; color: #000000;">
                    <option value="" disabled selected style="color: #6b7280;">-- Pilih Kategori Buku --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" style="color: #000000; background-color: #ffffff;">
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Aksi Bawah -->
            <div style="text-align: right; margin-top: 20px;">
                <a href="/dashboard" style="padding: 10px 15px; background: #e5e7eb; color: #374151; text-decoration: none; border-radius: 5px; font-weight: bold; margin-right: 10px; display: inline-block;">Batal</a>
                <button type="submit" style="padding: 10px 20px; background: #4f46e5; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Simpan Buku</button>
            </div>

        </form>

    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px;">

    <!-- Navbar Atas -->
    <div style="background: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
        <h2 style="margin: 0; color: #333; font-size: 20px;">Daftar Buku Perpustakaan</h2>
        <p style="margin: 5px 0 0 0; color: #6b7280; font-size: 14px;">Selamat datang, <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        <!-- Tombol Logout -->
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <a href="{{ route('profile.edit') }}" style="padding: 8px 15px; background: #6b7280; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px;">Profil</a>
            <button type="submit" style="padding: 8px 15px; background: #ef4444; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Logout</button>
            
        </form>
        
    </div>

    <!-- Konten Daftar Buku dalam Bentuk Card -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; align-items: stretch;">
    @forelse($bukus as $buku)
        <!-- Tambahkan height: 100% dan pastikan flexbox berjalan sempurna -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 100%; box-sizing: border-box;">
            
            <div>
                <!-- Badge Kategori -->
                <span style="display: inline-block; background: #e0e7ff; color: #4f46e5; font-size: 12px; font-weight: bold; padding: 4px 8px; border-radius: 4px; margin-bottom: 10px;">
                    {{ $buku->kategori->nama ?? 'Tanpa Kategori' }}
                </span>
                
                <!-- Judul Buku -->
                <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #1f2937;">{{ $buku->judul }}</h3>
                
                <!-- Penulis & Tahun -->
                <p style="margin: 5px 0; color: #4b5563; font-size: 14px;"><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                <p style="margin: 5px 0 15px 0; color: #4b5563; font-size: 14px;"><strong>Tahun:</strong> {{ $buku->tahun_terbit }}</p>
            </div>

            <!-- Tombol Aksi Detail (Otomatis menempel di bawah card) -->
            <div>
                <a href="{{ route('buku.show', $buku->id) }}" style="display: block; text-align: center; background: #4f46e5; color: white; padding: 8px; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: bold;">Lihat Detail</a>
            </div>
            
        </div>
    @empty
        <p style="grid-column: 1 / -1; text-align: center; color: #6b7280;">Belum ada data buku yang tersedia.</p>
    @endforelse
</div>

</body>
</html>
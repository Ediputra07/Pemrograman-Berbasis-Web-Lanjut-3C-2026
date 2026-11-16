<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin & Petugas</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px;">
    
    <div style="max-width: 1100px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        
        <!-- Header & Navigasi -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <div>
                <h2 style="margin: 0; color: #1f2937;">Dashboard Operasional Perpustakaan</h2>
                <p style="margin: 5px 0 0 0; color: #6b7280; font-size: 14px;">Selamat datang, <strong>{{ Auth::user()->name }}</strong></p>
            </div>
            
            <div style="display: flex; gap: 10px; align-items: center;">
                <!-- Tombol Kelola Peminjaman (Admin & Petugas) -->
                <a href="{{ route('admin.peminjaman.index') }}" style="background: #3b82f6; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: bold;">Kelola Peminjaman</a>
                
                <!-- Tombol Kelola User (KHUSUS ADMIN) -->
                @role('admin')
                    <a href="{{ route('admin.users.index') }}" style="background: #8b5cf6; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: bold;"> Kelola User</a>
                @endrole

                <!-- Tombol Logout -->
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <!-- Tombol Profil untuk Admin & Petugas di Dashboard -->
                    <a href="{{ route('profile.edit') }}" style="background: #6b7280; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: bold;">Profil</a>
                    <button type="submit" style="background: #ef4444; color: white; border: none; padding: 8px 15px; border-radius: 5px; font-size: 14px; font-weight: bold; cursor: pointer;">Logout</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol Tambah Buku -->
        <div style="margin-bottom: 20px;">
            <!-- <a href="{{ route('buku-crud.create') }}" style="background: #10b981; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: bold;">+ Tambah Buku Baru</a> -->
             @can('kelola-buku')
    <a href="{{ route('buku.create') }}">Tambah Buku</a>
@endcan
<div class="mb-4">
    <a href="{{ route('laporan.pdf') }}" class="btn btn-danger" target="_blank">
        <i class="fas fa-file-pdf"></i> Cetak Laporan PDF
    </a>
</div>
        </div>

        <!-- Tabel Daftar Buku -->
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 10px; font-size: 14px;">Judul Buku</th>
                    <th style="padding: 10px; font-size: 14px;">Penulis</th>
                    <th style="padding: 10px; font-size: 14px;">Tahun</th>
                    <th style="padding: 10px; font-size: 14px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bukus ?? [] as $buku)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <!-- <td style="padding: 10px; font-weight: bold; color: #1f2937;">{{ $buku->judul }}</td> -->
                        <td style="padding: 10px; font-weight: bold; color: #1f2937;">{!! $buku->judul !!}</td>
                        <td style="padding: 10px; color: #4b5563;">{{ $buku->penulis }}</td>
                        <td style="padding: 10px; color: #4b5563;">{{ $buku->tahun_terbit }}</td>
                        <td style="padding: 10px; text-align: center;">
                            <a href="{{ route('buku-crud.edit', $buku->id) }}" style="background: #f59e0b; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 12px; font-weight: bold; margin-right: 5px;">Edit</a>
                            
                            <form action="{{ route('buku-crud.destroy', $buku->id) }}" method="POST" style="display: inline-block; margin: 0;" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #ef4444; color: white; border: none; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: #6b7280;">Belum ada data buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</body>
</html>
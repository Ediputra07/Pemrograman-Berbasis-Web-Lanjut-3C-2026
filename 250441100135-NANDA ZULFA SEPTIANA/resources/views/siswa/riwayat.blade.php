<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman Saya - Siswa</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px;">
    
    <div style="max-width: 900px; margin: 30px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; color: #1f2937;">📜 Riwayat Peminjaman Buku Saya</h2>
            <a href="{{ route('siswa.dashboard') }}" style="color: #4f46e5; text-decoration: none; font-weight: bold; font-size: 14px;">&larr; Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 5px; margin-bottom: 20px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; color: #374151; font-size: 14px;">Judul Buku</th>
                    <th style="padding: 12px; color: #374151; font-size: 14px;">Tanggal Pinjam</th>
                    <th style="padding: 12px; color: #374151; font-size: 14px;">Status</th>
                    <th style="padding: 12px; color: #374151; font-size: 14px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $item)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px; color: #1f2937; font-weight: bold;">
                            {{ $item->buku->judul ?? 'Judul Buku Tidak Ditemukan' }}
                        </td>
                        <td style="padding: 12px; color: #6b7280; font-size: 14px;">
                            {{ $item->tanggal_pinjam }}
                        </td>
                        <td style="padding: 12px;">
                            <span style="padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; background: {{ $item->status == 'dipinjam' ? '#fef3c7; color: #d97706;' : '#d1fae5; color: #065f46;' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            @if($item->status == 'dipinjam')
                                <form action="{{ route('peminjaman.kembalikan', $item->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                </form>
                            @else
                                <span style="color: #9ca3af; font-size: 13px; font-weight: bold;">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 30px; color: #6b7280; font-size: 14px;">
                            Belum ada riwayat peminjaman buku.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</body>
</html>
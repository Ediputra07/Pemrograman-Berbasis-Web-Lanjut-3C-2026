<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px;">
    
    <div style="max-width: 600px; margin: 30px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        
        <!-- Tombol Kembali Otomatis Berdasarkan Role -->
        <div style="margin-bottom: 20px;">
            @role('siswa')
                <a href="{{ route('siswa.dashboard') }}" style="color: #4f46e5; text-decoration: none; font-weight: bold; font-size: 14px;">&larr; Kembali ke Dashboard Siswa</a>
            @else
                <a href="{{ route('dashboard') }}" style="color: #4f46e5; text-decoration: none; font-weight: bold; font-size: 14px;">&larr; Kembali ke Dashboard Utama</a>
            @endrole
        </div>

        <h2 style="margin: 0 0 20px 0; color: #1f2937;">Pengaturan Profil</h2>

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 5px; margin-bottom: 20px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Ubah Profil -->
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #374151; font-size: 14px;">Nama Lengkap:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px; box-sizing: border-box;" required>
                @error('name')
                    <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #374151; font-size: 14px;">Alamat Email:</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px; box-sizing: border-box;" required>
                @error('email')
                    <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <button type="submit" style="background: #4f46e5; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 14px;">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna & Role - Admin</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px;">
    
    <div style="max-width: 900px; margin: 30px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; color: #1f2937;">👥 Kelola Data & Role Pengguna</h2>
            <a href="{{ route('dashboard') }}" style="color: #4f46e5; text-decoration: none; font-weight: bold; font-size: 14px;">&larr; Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 5px; margin-bottom: 20px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; color: #374151; font-size: 14px;">Nama</th>
                    <th style="padding: 12px; color: #374151; font-size: 14px;">Email</th>
                    <th style="padding: 12px; color: #374151; font-size: 14px;">Role Saat Ini</th>
                    <th style="padding: 12px; color: #374151; font-size: 14px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px; color: #1f2937; font-weight: bold;">{{ $user->name }}</td>
                        <td style="padding: 12px; color: #6b7280; font-size: 14px;">{{ $user->email }}</td>
                        <td style="padding: 12px;">
                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; background: #e0e7ff; color: #4f46e5;">
                                {{ ucfirst($user->getRoleNames()->implode(', ') ?: 'Tanpa Role') }}
                            </span>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" style="background: #f59e0b; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 12px; font-weight: bold;">
                                Edit Role / Data
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>
</html>
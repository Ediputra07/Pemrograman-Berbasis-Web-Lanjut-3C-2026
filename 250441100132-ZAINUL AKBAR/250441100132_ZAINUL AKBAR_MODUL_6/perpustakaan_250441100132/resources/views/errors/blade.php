<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center p-8 bg-white rounded-lg shadow-md max-w-md">
        <h1 class="text-6xl font-bold text-red-600 mb-4">403</h1>
        <h2 class="text-xl font-bold text-gray-800 mb-2">Akses Ditolak</h2>
        <p class="text-gray-600 mb-6">Peran Anda telah diperbarui atau Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        
        <div class="flex gap-4 justify-center">
            <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                Ke Dashboard
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
                    Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital UTM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center h-screen">
    
    <div class="bg-white p-10 rounded-xl shadow-lg text-center max-w-lg">
        <h1 class="text-3xl font-extrabold text-blue-700 mb-4">Perpustakaan Digital</h1>
        <p class="text-gray-600 mb-8">Selamat datang! Silakan masuk ke dalam sistem untuk meminjam buku, melihat riwayat, atau mengelola data perpustakaan.</p>
        
        <div class="flex justify-center gap-4">
            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded transition duration-300">
                Masuk (Log in)
            </a>
            <a href="{{ route('register') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded transition duration-300">
                Daftar Akun
            </a>
        </div>
    </div>

</body>
</html>
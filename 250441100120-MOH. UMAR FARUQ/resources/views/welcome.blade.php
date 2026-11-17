<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpustakaan Digital</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100 text-gray-800">
        <div class="relative min-h-screen flex flex-col justify-center items-center">
            
            <!-- Tombol Login / Register di Pojok Kanan Atas -->
            @if (Route::has('login'))
                <div class="absolute top-0 right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-indigo-600">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-indigo-600">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- Konten Utama Halaman Sambutan Perpustakaan -->
            <div class="max-w-4xl mx-auto p-6 text-center">
                <div class="flex justify-center mb-4">
                    <!-- Ikon Buku SVG -->
                    <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl mb-4">
                    Sistem Informasi Perpustakaan Digital
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Kelola data buku, kategori, dan peminjaman dengan mudah, cepat, dan terstruktur.
                </p>
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block bg-indigo-600 text-white font-semibold px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
                            Masuk ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block bg-indigo-600 text-white font-semibold px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
                            Mulai Masuk (Login)
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>
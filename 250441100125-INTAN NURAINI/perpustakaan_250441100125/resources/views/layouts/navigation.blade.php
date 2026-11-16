
<nav class="w-full border-b-4 border-emerald-700 bg-emerald-950 shadow-md">

    @php
        $user = auth()->user();

        $dashboardRoute = 'dashboard';

        if ($user?->hasRole('Admin')) {
            $dashboardRoute = 'admin.dashboard';
        } elseif ($user?->hasRole('Petugas')) {
            $dashboardRoute = 'petugas.dashboard';
        } elseif ($user?->hasRole('Siswa')) {
            $dashboardRoute = 'siswa.dashboard';
        }

        $halamanProfilAdmin = $user?->hasRole('Admin')
            && request()->routeIs('profile.edit');
    @endphp

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-16 flex-wrap items-center justify-between gap-3 py-3">

            {{-- Logo --}}
            <a href="{{ route($dashboardRoute) }}"
               class="shrink-0 text-xl font-bold tracking-wide text-white">
                Perpustakaan Digital
            </a>

            <div class="flex flex-wrap items-center justify-end gap-2">

                {{-- Dashboard --}}
                <a href="{{ route($dashboardRoute) }}"
                   class="rounded-md px-3 py-2 text-sm font-semibold text-white transition hover:bg-emerald-800">
                    Dashboard
                </a>

                {{-- Navigasi selain halaman Edit Profil Admin --}}
                @if(!$halamanProfilAdmin)

                    {{-- Daftar Buku Admin dan Petugas --}}
                    @if($user?->hasRole('Admin') || $user?->hasRole('Petugas'))
                        <a href="{{ route('kelola-buku') }}"
                           class="rounded-md px-3 py-2 text-sm font-semibold text-white transition hover:bg-emerald-800">
                            Daftar Buku
                        </a>
                    @endif

                    {{-- Daftar Buku Siswa --}}
                    @if($user?->hasRole('Siswa'))
                        <a href="{{ route('katalog-buku') }}"
                           class="rounded-md px-3 py-2 text-sm font-semibold text-white transition hover:bg-emerald-800">
                            Daftar Buku
                        </a>
                    @endif

                    {{-- Kelola Anggota khusus Admin --}}
                    @if($user?->hasRole('Admin'))
                        <a href="{{ route('anggota.index') }}"
                           class="rounded-md px-3 py-2 text-sm font-semibold text-white transition hover:bg-emerald-800">
                            Kelola Anggota
                        </a>
                    @endif

                    {{-- Profil --}}
                    <a href="{{ route('profile.edit') }}"
                       class="rounded-md px-3 py-2 text-sm font-semibold text-white transition hover:bg-emerald-800">
                        Profil
                    </a>

                @endif

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-md bg-white px-4 py-2 text-sm font-bold text-emerald-950 transition hover:bg-emerald-100">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>
</nav>

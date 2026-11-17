<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->can('akses dashboard admin') || Auth::user()->can('akses dashboard petugas') ? route('dashboard') : route('buku.katalog') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @canany(['akses dashboard admin', 'akses dashboard petugas'])
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endcanany

                    @can('lihat daftar buku')
                        <x-nav-link :href="route('buku.katalog')" :active="request()->routeIs('buku.katalog')">
                            {{ __('Katalog Buku') }}
                        </x-nav-link>
                    @endcan

                    @can('kelola data buku')
                        <x-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.*')">
                            {{ __('Kelola Buku') }}
                        </x-nav-link>
                    @endcan

                    @can('kelola data pengguna')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index', 'users.create', 'users.edit')">
                            {{ __('Pengguna') }}
                        </x-nav-link>
                    @endcan

                    @can('kelola role pengguna')
                        <x-nav-link :href="route('users.roles.index')" :active="request()->routeIs('users.roles.*')">
                            {{ __('Role Pengguna') }}
                        </x-nav-link>
                    @endcan

                    @can('kelola peminjaman')
                        <x-nav-link :href="route('peminjaman.kelola')" :active="request()->routeIs('peminjaman.kelola')">
                            {{ __('Peminjaman') }}
                        </x-nav-link>
                    @endcan

                    @can('kelola pengembalian')
                        <x-nav-link :href="route('pengembalian.index')" :active="request()->routeIs('pengembalian.*')">
                            {{ __('Pengembalian') }}
                        </x-nav-link>
                    @endcan

                    @can('lihat laporan perpustakaan')
                        <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                    @endcan

                    @can('melihat status peminjaman sendiri')
                        <x-nav-link :href="route('peminjaman.status')" :active="request()->routeIs('peminjaman.status')">
                            {{ __('Status Pinjaman') }}
                        </x-nav-link>
                    @endcan

                    @can('melihat riwayat peminjaman sendiri')
                        <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index', 'peminjaman.saya')">
                            {{ __('Riwayat Pinjaman') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @can('lihat profil sendiri')
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil Saya') }}
                            </x-dropdown-link>
                        @endcan
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @canany(['akses dashboard admin', 'akses dashboard petugas'])
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endcanany

            @can('lihat daftar buku')
                <x-responsive-nav-link :href="route('buku.katalog')" :active="request()->routeIs('buku.katalog')">
                    {{ __('Katalog Buku') }}
                </x-responsive-nav-link>
            @endcan
            @can('kelola data buku')
                <x-responsive-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.*')">
                    {{ __('Kelola Buku') }}
                </x-responsive-nav-link>
            @endcan
            @can('kelola data pengguna')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index', 'users.create', 'users.edit')">
                    {{ __('Pengguna') }}
                </x-responsive-nav-link>
            @endcan
            @can('kelola role pengguna')
                <x-responsive-nav-link :href="route('users.roles.index')" :active="request()->routeIs('users.roles.*')">
                    {{ __('Role Pengguna') }}
                </x-responsive-nav-link>
            @endcan
            @can('kelola peminjaman')
                <x-responsive-nav-link :href="route('peminjaman.kelola')" :active="request()->routeIs('peminjaman.kelola')">
                    {{ __('Peminjaman') }}
                </x-responsive-nav-link>
            @endcan
            @can('kelola pengembalian')
                <x-responsive-nav-link :href="route('pengembalian.index')" :active="request()->routeIs('pengembalian.*')">
                    {{ __('Pengembalian') }}
                </x-responsive-nav-link>
            @endcan
            @can('lihat laporan perpustakaan')
                <x-responsive-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
            @endcan
            @can('melihat status peminjaman sendiri')
                <x-responsive-nav-link :href="route('peminjaman.status')" :active="request()->routeIs('peminjaman.status')">
                    {{ __('Status Pinjaman') }}
                </x-responsive-nav-link>
            @endcan
            @can('melihat riwayat peminjaman sendiri')
                <x-responsive-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index', 'peminjaman.saya')">
                    {{ __('Riwayat Pinjaman') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @can('lihat profil sendiri')
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profil Saya') }}
                    </x-responsive-nav-link>
                @endcan
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
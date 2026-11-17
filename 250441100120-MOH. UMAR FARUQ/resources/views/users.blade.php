<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700" role="status">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700" role="alert">{{ session('error') }}</div>
                @endif

                <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Pengguna Sistem</h3>
                    <a href="{{ route('users.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Tambah Pengguna</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-sm">
                        <thead>
                            <tr class="bg-blue-50 text-left text-gray-700 text-sm uppercase font-semibold">
                                <th class="py-3 px-4 border-b">Nama</th>
                                <th class="py-3 px-4 border-b">Email</th>
                                <th class="py-3 px-4 border-b">Role / Peran</th>
                                <th class="py-3 px-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block bg-blue-100 text-blue-800 text-[11px] px-2.5 py-1 rounded-full font-semibold">
                                            {{ $user->getRoleNames()->implode(', ') ?: '-' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{ route('users.edit', $user) }}" class="px-2.5 py-1 bg-amber-500 text-white rounded hover:bg-amber-600 transition text-xs font-semibold">
                                            Ubah
                                        </a>
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline-block" onsubmit="return confirm('Hapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs font-semibold">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada data pengguna.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
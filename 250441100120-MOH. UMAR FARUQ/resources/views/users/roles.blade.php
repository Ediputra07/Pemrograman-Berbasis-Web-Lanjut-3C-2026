<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Role Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4 text-sm text-green-700" role="status">{{ session('success') }}</div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white p-6 shadow-sm">
                <div class="mb-5">
                    <h3 class="text-lg font-semibold text-gray-900">Hak Akses Setiap Pengguna</h3>
                    <p class="mt-1 text-sm text-gray-500">Pilih satu role sesuai tugas pengguna di perpustakaan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-blue-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role Saat Ini</th>
                                <th class="px-4 py-3">Ubah Role</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                    <td class="px-4 py-3">{{ $user->getRoleNames()->implode(', ') ?: '-' }}</td>
                                    <td class="px-4 py-3">
                                        <form method="POST" action="{{ route('users.roles.update', $user) }}" class="flex flex-wrap items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" required class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>{{ ucfirst($role->name) }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700">
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada data pengguna.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

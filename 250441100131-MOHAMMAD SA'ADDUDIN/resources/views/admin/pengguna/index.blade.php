@extends('layouts.app')

@section('judul', 'Kelola Pengguna')

@section('konten')
    <h2>Kelola Pengguna</h2>

    <p>
        <a href="{{ route('admin.pengguna.create') }}" class="tombol">Tambah Pengguna</a>
    </p>

    <div class="tabel-gulir">
        <table class="tabel">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftar as $i => $pengguna)
                    <tr>
                        <td>{{ $daftar->firstItem() + $i }}</td>
                        <td>{{ $pengguna->name }}</td>
                        <td>{{ $pengguna->email }}</td>
                        <td>
                            {{-- Ubah role: hanya yang punya permission 'kelola role pengguna' --}}
                            @can('kelola role pengguna')
                                @if ($pengguna->is(auth()->user()))
                                    <span class="badge badge--dipinjam">{{ $pengguna->getRoleNames()->first() }}</span>
                                    <small class="catatan">(akun Anda)</small>
                                @else
                                    <form method="POST" action="{{ route('admin.pengguna.role', $pengguna) }}" class="form-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" aria-label="Role untuk {{ $pengguna->name }}">
                                            @foreach ($daftarRole as $role)
                                                <option value="{{ $role }}" @selected($pengguna->hasRole($role))>{{ $role }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="tombol tombol--kecil">Simpan</button>
                                    </form>
                                @endif
                            @else
                                {{ $pengguna->getRoleNames()->implode(', ') }}
                            @endcan
                        </td>
                        <td class="aksi">
                            <a href="{{ route('admin.pengguna.edit', $pengguna) }}" class="tombol tombol--kecil tombol--peringatan">Ubah</a>
                            @unless ($pengguna->is(auth()->user()))
                                <form method="POST" action="{{ route('admin.pengguna.destroy', $pengguna) }}" class="form-inline"
                                      onsubmit="return confirm('Hapus pengguna ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="tombol tombol--kecil tombol--bahaya">Hapus</button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="tabel__info">Belum ada pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('partials.paginasi', ['paginator' => $daftar])
@endsection

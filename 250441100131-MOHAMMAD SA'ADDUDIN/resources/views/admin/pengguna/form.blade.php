@extends('layouts.app')

@section('judul', $pengguna ? 'Ubah Pengguna' : 'Tambah Pengguna')

@section('konten')
    <section class="kartu-form kartu-auth" aria-labelledby="judul-form-pengguna">
        <h2 id="judul-form-pengguna">{{ $pengguna ? 'Ubah Pengguna' : 'Tambah Pengguna' }}</h2>

        <form method="POST"
              action="{{ $pengguna ? route('admin.pengguna.update', $pengguna) : route('admin.pengguna.store') }}">
            @csrf
            @if ($pengguna)
                @method('PUT')
            @endif

            <div class="bidang">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $pengguna?->name) }}" required>
                @error('name')
                    <small class="galat">{{ $message }}</small>
                @enderror
            </div>

            <div class="bidang">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $pengguna?->email) }}" required>
                @error('email')
                    <small class="galat">{{ $message }}</small>
                @enderror
            </div>

            <div class="bidang">
                <label for="no_telepon">No. telepon</label>
                <input type="text" id="no_telepon" name="no_telepon"
                       value="{{ old('no_telepon', $pengguna?->anggota?->no_telepon) }}" inputmode="numeric" required>
                @error('no_telepon')
                    <small class="galat">{{ $message }}</small>
                @enderror
            </div>

            {{-- Role hanya bisa dipilih saat membuat akun, dan hanya oleh yang berwenang --}}
            @if (! $pengguna)
                @can('kelola role pengguna')
                    <div class="bidang">
                        <label for="role">Role</label>
                        <select id="role" name="role">
                            @foreach ($daftarRole as $role)
                                <option value="{{ $role }}" @selected(old('role', 'siswa') === $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <small class="galat">{{ $message }}</small>
                        @enderror
                    </div>
                @endcan
            @endif

            <div class="bidang">
                <label for="password">Kata sandi {{ $pengguna ? '(kosongkan jika tidak diubah)' : '' }}</label>
                <input type="password" id="password" name="password" autocomplete="new-password" {{ $pengguna ? '' : 'required' }}>
                @error('password')
                    <small class="galat">{{ $message }}</small>
                @enderror
            </div>

            <div class="bidang">
                <label for="password_confirmation">Konfirmasi kata sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
            </div>

            <div class="form-buku__aksi">
                <button type="submit" class="tombol">Simpan</button>
                <a href="{{ route('admin.pengguna.index') }}" class="tombol tombol--sekunder">Batal</a>
            </div>
        </form>
    </section>
@endsection

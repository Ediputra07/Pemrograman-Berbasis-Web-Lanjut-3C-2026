<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Anggota - Perpustakaan Digital</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #ecfdf5;
            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #064e3b;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 30px 15px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 21px;
            font-weight: bold;
            padding: 10px 15px 35px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 25px;
            line-height: 1.4;
        }

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px;
            margin-bottom: 8px;
            border-radius: 10px;
            font-size: 15px;
            transition: 0.2s;
        }

        .menu a:hover,
        .menu a.active {
            background: #047857;
        }

        .logout {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 25px;
        }

        .logout button {
            width: 100%;
            padding: 14px;
            background: transparent;
            border: none;
            color: white;
            text-align: left;
            font-size: 15px;
            cursor: pointer;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            min-height: 85px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 15px 35px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #111827;
            text-decoration: none;
            font-weight: bold;
        }

        .admin-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .content {
            padding: 40px 35px;
        }

        .page-title {
            font-size: 38px;
            font-weight: bold;
            color: #064e3b;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748b;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: white;
            border-radius: 15px;
            padding: 22px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
            border-left: 5px solid #047857;
        }

        .summary-label {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .summary-number {
            color: #064e3b;
            font-size: 30px;
            font-weight: bold;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 22px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
            margin-bottom: 25px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            color: #123047;
            margin-bottom: 8px;
        }

        .card-description {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 22px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
            color: #374151;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #047857;
            box-shadow: 0 0 0 2px rgba(4,120,87,0.12);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-primary {
            background: #065f46;
            color: white;
        }

        .btn-primary:hover {
            background: #064e3b;
        }

        .btn-edit {
            background: #2563eb;
            color: white;
        }

        .btn-edit:hover {
            background: #1d4ed8;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .btn-delete:hover {
            background: #b91c1c;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .alert {
            padding: 14px 17px;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 750px;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background: #065f46;
            color: white;
        }

        thead th {
            padding: 17px 15px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #d1d5db;
        }

        tbody td {
            padding: 15px;
            border: 1px solid #e2e8f0;
            color: #26364b;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #ecfdf5;
        }

        .number {
            text-align: center;
            width: 65px;
        }

        .role-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 30px;
            background: #d1fae5;
            color: #065f46;
            font-size: 12px;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        .action-buttons form {
            margin: 0;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #64748b;
        }

        .modal {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(17,24,39,0.55);
            padding: 20px;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .modal-header h3 {
            font-size: 21px;
            color: #064e3b;
        }

        .close-modal {
            border: none;
            background: transparent;
            font-size: 27px;
            color: #9ca3af;
            cursor: pointer;
        }

        .modal-fields {
            display: flex;
            flex-direction: column;
            gap: 17px;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
        }

        @media (max-width: 900px) {
            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 15px;
            }

            .brand {
                padding-bottom: 15px;
            }

            .menu a {
                padding: 11px;
                font-size: 13px;
            }

            .topbar {
                min-height: 60px;
                padding: 12px 20px;
            }

            .content {
                padding: 25px 15px;
            }

            .page-title {
                font-size: 29px;
            }

            .subtitle {
                font-size: 15px;
            }

            .card {
                padding: 16px;
            }
        }

        @media (max-width: 550px) {
            .summary-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    {{-- SIDEBAR ADMIN --}}
    <aside class="sidebar">

        <div class="brand">
            📖 Perpustakaan<br>Digital
        </div>

        <nav class="menu">

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('kelola-buku') }}"
               class="{{ request()->routeIs('kelola-buku') ? 'active' : '' }}">
                📚 Daftar Buku
            </a>

            <a href="{{ route('anggota.index') }}"
               class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                👥 Kelola Anggota
            </a>

            <a href="{{ route('admin.peminjaman') }}"
               class="{{ request()->routeIs('admin.peminjaman') ? 'active' : '' }}">
                📋 Kelola Peminjaman
            </a>

            <a href="{{ route('admin.pengembalian') }}"
               class="{{ request()->routeIs('admin.pengembalian') ? 'active' : '' }}">
                📥 Data Pengembalian
            </a>

            {{-- NAVIGASI LAPORAN PERPUSTAKAAN --}}
            <a href="{{ route('admin.laporan') }}"
               class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                📊 Laporan Perpustakaan
            </a>

            <a href="{{ route('profile.edit') }}"
               class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                👤 Profil Admin
            </a>

        </nav>

        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">↪ Logout</button>
            </form>
        </div>

    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="main">

        <header class="topbar">
            <a href="{{ route('profile.edit') }}" class="admin-profile">
                <span class="admin-icon">👤</span>
                <span>{{ Auth::user()->name }} (Admin) ⌄</span>
            </a>
        </header>

        <section class="content">

            <h1 class="page-title">Kelola Anggota</h1>
            <p class="subtitle">
                Kelola akun Petugas dan Siswa perpustakaan
            </p>

            {{-- NOTIFIKASI --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Periksa kembali data yang dimasukkan:</strong>
                    <ul style="margin: 8px 0 0 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- RINGKASAN --}}
            <div class="summary-grid">

                <div class="summary-card">
                    <p class="summary-label">Total Anggota</p>
                    <p class="summary-number">{{ $anggota->count() }}</p>
                </div>

                <div class="summary-card">
                    <p class="summary-label">Petugas</p>
                    <p class="summary-number">
                        {{ $anggota->filter(fn ($user) => $user->hasRole('Petugas'))->count() }}
                    </p>
                </div>

                <div class="summary-card">
                    <p class="summary-label">Siswa</p>
                    <p class="summary-number">
                        {{ $anggota->filter(fn ($user) => $user->hasRole('Siswa'))->count() }}
                    </p>
                </div>

            </div>

            {{-- FORM TAMBAH ANGGOTA --}}
            <div class="card">

                <h2 class="card-title">Tambah Anggota</h2>
                <p class="card-description">
                    Tambahkan akun Petugas atau Siswa baru.
                </p>

                <form action="{{ route('anggota.store') }}" method="POST">
                    @csrf

                    <div class="form-grid">

                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="contoh@email.com">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                minlength="8"
                                placeholder="Minimal 8 karakter">
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="Petugas" {{ old('role') == 'Petugas' ? 'selected' : '' }}>
                                    Petugas
                                </option>
                                <option value="Siswa" {{ old('role') == 'Siswa' ? 'selected' : '' }}>
                                    Siswa
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            Tambah Anggota
                        </button>
                    </div>
                </form>

            </div>

            {{-- TABEL ANGGOTA --}}
            <div class="card">

                <h2 class="card-title">Daftar Anggota</h2>
                <p class="card-description">
                    Data akun yang terdaftar di perpustakaan.
                </p>

                <div class="table-wrapper">
                    <table>

                        <thead>
                            <tr>
                                <th class="number">No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($anggota as $index => $user)

                                <tr>
                                    <td class="number">
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        {{ $user->name }}

                                        @if ($user->id == auth()->id())
                                            <small style="color:#047857;">(Akun Anda)</small>
                                        @endif
                                    </td>

                                    <td>{{ $user->email }}</td>

                                    <td>
                                        @foreach ($user->getRoleNames() as $role)
                                            <span class="role-badge">
                                                {{ $role }}
                                            </span>
                                        @endforeach
                                    </td>

                                    <td>
                                        <div class="action-buttons">

                                            {{-- TOMBOL EDIT --}}
                                            <button
                                                type="button"
                                                class="btn btn-edit"
                                                onclick="openEditModal(
                                                    {{ $user->id }},
                                                    @js($user->name),
                                                    @js($user->email),
                                                    @js($user->getRoleNames()->first())
                                                )">
                                                Edit
                                            </button>

                                            {{-- TOMBOL HAPUS --}}
                                            @if ($user->id != auth()->id())
                                                <form
                                                    action="{{ route('anggota.destroy', $user->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-delete">
                                                        Hapus
                                                    </button>

                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="empty">
                                        Belum ada data anggota.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

        </section>

    </main>

</div>

{{-- MODAL EDIT ANGGOTA --}}
<div id="editModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">
            <h3>Edit Anggota</h3>

            <button
                type="button"
                onclick="closeEditModal()"
                class="close-modal">
                &times;
            </button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-fields">

                <div class="form-group">
                    <label for="edit_name">Nama Lengkap</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="edit_email">Email</label>
                    <input type="email" id="edit_email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="edit_role">Role</label>
                    <select id="edit_role" name="role" required>
                        <option value="Petugas">Petugas</option>
                        <option value="Siswa">Siswa</option>
                    </select>
                </div>

            </div>

            <div class="modal-actions">

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="btn btn-secondary">
                    Batal
                </button>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

            </div>
        </form>

    </div>

</div>

{{-- JAVASCRIPT MODAL --}}
<script>
    function openEditModal(id, name, email, role) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');

        form.action = `/anggota/${id}`;

        document.getElementById('edit_name').value = name || '';
        document.getElementById('edit_email').value = email || '';
        document.getElementById('edit_role').value =
            role === 'Petugas' ? 'Petugas' : 'Siswa';

        modal.classList.add('show');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('show');
    }

    document.getElementById('editModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeEditModal();
        }
    });
</script>

</body>
</html>

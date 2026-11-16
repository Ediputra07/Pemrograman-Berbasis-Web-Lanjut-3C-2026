@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();

    $bolehKelolaBuku = $user->can('kelola-buku');

    $isAdmin = $user->hasRole('Admin');
    $isPetugas = $user->hasRole('Petugas');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Perpustakaan Digital</title>

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

        .card {
            background: white;
            border-radius: 15px;
            padding: 22px;
            margin-bottom: 25px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            color: #123047;
            margin-bottom: 20px;
        }

        .form-buku {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .form-buku label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 14px;
        }

        .form-buku input,
        .form-buku select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
        }

        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .btn-buku {
            padding: 10px 16px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            color: white;
            background: #065f46;
            font-size: 14px;
        }

        .btn-buku:hover {
            opacity: 0.9;
        }

        .btn-buku:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-edit {
            background: #2563eb;
        }

        .btn-hapus {
            background: #dc2626;
        }

        .btn-batal {
            background: #64748b;
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
            padding: 16px 13px;
            font-size: 14px;
            border: 1px solid #d1d5db;
        }

        tbody td {
            padding: 14px 13px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #ecfdf5;
        }

        .number {
            text-align: center;
            width: 65px;
        }

        .aksi-buku {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .pesan-buku {
            margin-bottom: 18px;
            padding: 13px;
            border-radius: 7px;
            overflow-wrap: anywhere;
        }

        .pesan-error {
            color: #991b1b;
            background: #fee2e2;
        }

        .pesan-sukses {
            color: #166534;
            background: #dcfce7;
        }

        .empty {
            text-align: center;
            padding: 25px;
        }

        .pagination-buku {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
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
                padding: 15px;
            }

            .card-title {
                font-size: 20px;
            }

            .form-buku {
                grid-template-columns: 1fr;
            }

            .form-actions {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <div class="brand">
            📖 Perpustakaan<br>Digital
        </div>

        <nav class="menu">

            {{-- MENU ADMIN --}}
            @if($isAdmin)

                <a href="{{ route('admin.dashboard') }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('kelola-buku') }}" class="active">
                    📚 Daftar Buku
                </a>

                <a href="{{ route('anggota.index') }}">
                    👥 Kelola Anggota
                </a>

                <a href="{{ route('admin.peminjaman') }}">
                    📋 Kelola Peminjaman
                </a>

                <a href="{{ route('admin.pengembalian') }}">
                    📥 Data Pengembalian
                </a>

                <a href="{{ route('admin.laporan') }}">
                    📊 Laporan Perpustakaan
                </a>

                <a href="{{ route('profile.edit') }}">
                    👤 Profil Admin
                </a>

            {{-- MENU PETUGAS --}}
            @elseif($isPetugas)

                <a href="{{ route('petugas.dashboard') }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('kelola-buku') }}" class="active">
                    📚 Daftar Buku
                </a>

                <a href="{{ route('admin.peminjaman') }}">
                    📋 Kelola Peminjaman
                </a>

                <a href="{{ route('admin.pengembalian') }}">
                    📥 Data Pengembalian
                </a>

                <a href="{{ route('admin.laporan') }}">
                    📊 Laporan Perpustakaan
                </a>

                <a href="{{ route('profile.edit') }}">
                    👤 Profil Petugas
                </a>

            @endif

        </nav>

        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">↪ Logout</button>
            </form>
        </div>

    </aside>

    <main class="main">

        <header class="topbar">
            <a href="{{ route('profile.edit') }}" class="admin-profile">
                <span class="admin-icon">👤</span>
                <span>{{ $user->name }} ({{ $role }}) ⌄</span>
            </a>
        </header>

        <section class="content">

            <h1 class="page-title">Daftar Buku</h1>

            <p class="subtitle">
                Kelola koleksi buku perpustakaan melalui API.
            </p>

            <div id="pesan" class="pesan-buku" role="status"
                 aria-live="polite" hidden></div>

            {{-- SOAL 3: FORM TAMBAH DAN EDIT HANYA UNTUK ADMIN DAN PETUGAS --}}
            @can('kelola-buku')
                <div class="card">
                    <h2 id="judul-form" class="card-title">Tambah Buku</h2>

                    <form id="form-buku" class="form-buku">
                        <input type="hidden" id="buku-id">

                        <div>
                            <label for="kategori_id">Kategori</label>
                            <select id="kategori_id" required>
                                <option value="">Pilih kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="judul">Judul Buku</label>
                            <input type="text" id="judul" required
                                   maxlength="255"
                                   placeholder="Masukkan judul buku">
                        </div>

                        <div>
                            <label for="penulis">Penulis</label>
                            <input type="text" id="penulis" required
                                   maxlength="255"
                                   placeholder="Masukkan nama penulis">
                        </div>

                        <div>
                            <label for="tahun_terbit">Tahun Terbit</label>
                            <input type="number" id="tahun_terbit" required
                                   min="1000" max="2100"
                                   placeholder="Masukkan tahun terbit">
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-buku" id="btn-simpan">
                                Simpan Buku
                            </button>

                            <button type="button" id="btn-batal"
                                    class="btn-buku btn-batal" hidden>
                                Batal Edit
                            </button>
                        </div>
                    </form>
                </div>
            @endcan

            <div class="card">
                <h2 class="card-title">📚 Daftar Koleksi Buku</h2>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th class="number">No.</th>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Tahun Terbit</th>

                                {{-- SOAL 3: KOLOM AKSI HANYA UNTUK YANG BERHAK --}}
                                @can('kelola-buku')
                                    <th>Aksi</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody id="daftar-buku">
                            <tr>
                                <td colspan="{{ $bolehKelolaBuku ? 6 : 5 }}"
                                    class="empty">
                                    Memuat data buku...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pagination-buku">
                    <button type="button" id="btn-sebelumnya"
                            class="btn-buku btn-batal" disabled>
                        Sebelumnya
                    </button>

                    <span id="info-halaman">Halaman 1</span>

                    <button type="button" id="btn-selanjutnya"
                            class="btn-buku" disabled>
                        Selanjutnya
                    </button>
                </div>
            </div>

        </section>
    </main>
</div>

{{-- SOAL 3: FORM CSRF UNTUK PENGHAPUSAN BUKU --}}
@can('kelola-buku')
    <form id="form-hapus-buku" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endcan

<script>
document.addEventListener('DOMContentLoaded', () => {

    const API = '/api/buku';

    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    )?.getAttribute('content') ?? '';

    // SOAL 3: Hak akses JavaScript mengikuti Gate kelola-buku.
    @can('kelola-buku')
        const bolehKelolaBuku = true;
    @else
        const bolehKelolaBuku = false;
    @endcan

    const form = document.getElementById('form-buku');
    const formHapus = document.getElementById('form-hapus-buku');
    const daftarBuku = document.getElementById('daftar-buku');
    const pesan = document.getElementById('pesan');
    const bukuId = document.getElementById('buku-id');
    const kategoriInput = document.getElementById('kategori_id');
    const judulInput = document.getElementById('judul');
    const penulisInput = document.getElementById('penulis');
    const tahunInput = document.getElementById('tahun_terbit');
    const judulForm = document.getElementById('judul-form');
    const btnSimpan = document.getElementById('btn-simpan');
    const btnBatal = document.getElementById('btn-batal');
    const btnSebelumnya = document.getElementById('btn-sebelumnya');
    const btnSelanjutnya = document.getElementById('btn-selanjutnya');
    const infoHalaman = document.getElementById('info-halaman');

    let halamanSebelumnya = null;
    let halamanSelanjutnya = null;
    let sedangMemuat = false;

    function tampilkanPesan(teks, jenis = 'error') {
        pesan.textContent = teks;
        pesan.className = 'pesan-buku ' +
            (jenis === 'sukses' ? 'pesan-sukses' : 'pesan-error');
        pesan.hidden = false;
    }

    function sembunyikanPesan() {
        pesan.textContent = '';
        pesan.hidden = true;
    }

    async function bacaRespons(response) {
        const data = await response.json().catch(() => ({}));

        if (!response.ok) {
            if (data.errors) {
                const detail = Object.values(data.errors).flat().join(' ');
                throw new Error(
                    detail || data.message || 'Permintaan gagal diproses.'
                );
            }

            throw new Error(
                data.message ||
                `Permintaan gagal dengan status ${response.status}.`
            );
        }

        return data;
    }

    async function muatBuku(url = API) {
        if (sedangMemuat) return;

        sedangMemuat = true;

        daftarBuku.innerHTML =
            `<tr><td colspan="${bolehKelolaBuku ? 6 : 5}" class="empty">Memuat data buku...</td></tr>`;

        btnSebelumnya.disabled = true;
        btnSelanjutnya.disabled = true;

        try {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            const hasil = await bacaRespons(response);
            const bukus = Array.isArray(hasil.data) ? hasil.data : [];

            halamanSebelumnya = hasil.links?.prev || null;
            halamanSelanjutnya = hasil.links?.next || null;

            const halaman = hasil.meta?.current_page ?? 1;
            const halamanAkhir = hasil.meta?.last_page ?? 1;
            const nomorAwal = hasil.meta?.from ?? 1;

            daftarBuku.replaceChildren();

            if (bukus.length === 0) {
                const baris = document.createElement('tr');
                const kolom = document.createElement('td');

                kolom.colSpan = bolehKelolaBuku ? 6 : 5;
                kolom.className = 'empty';
                kolom.textContent = 'Belum ada data buku.';

                baris.appendChild(kolom);
                daftarBuku.appendChild(baris);

            } else {

                bukus.forEach((buku, index) => {
                    const baris = document.createElement('tr');

                    [
                        nomorAwal + index,
                        buku.kategori?.nama ?? buku.kategori ?? '-',
                        buku.judul ?? '-',
                        buku.penulis ?? '-',
                        buku.tahun_terbit ?? buku.tahun ?? '-'
                    ].forEach((item) => {
                        const kolom = document.createElement('td');
                        kolom.textContent = String(item);
                        baris.appendChild(kolom);
                    });

                    // SOAL 3: TOMBOL EDIT DAN HAPUS HANYA DIBUAT JIKA GATE MENGIZINKAN.
                    if (bolehKelolaBuku) {

                        const kolomAksi = document.createElement('td');
                        const wadahAksi = document.createElement('div');

                        wadahAksi.className = 'aksi-buku';

                        const tombolEdit = document.createElement('button');

                        tombolEdit.type = 'button';
                        tombolEdit.className = 'btn-buku btn-edit';
                        tombolEdit.textContent = 'Edit';

                        tombolEdit.addEventListener(
                            'click',
                            () => editBuku(buku.id)
                        );

                        const tombolHapus = document.createElement('button');

                        tombolHapus.type = 'button';
                        tombolHapus.className = 'btn-buku btn-hapus';
                        tombolHapus.textContent = 'Hapus';

                        tombolHapus.addEventListener(
                            'click',
                            () => hapusBuku(buku)
                        );

                        wadahAksi.append(tombolEdit, tombolHapus);
                        kolomAksi.appendChild(wadahAksi);
                        baris.appendChild(kolomAksi);
                    }

                    daftarBuku.appendChild(baris);
                });
            }

            infoHalaman.textContent =
                `Halaman ${halaman} dari ${halamanAkhir}`;

            btnSebelumnya.disabled = !halamanSebelumnya;
            btnSelanjutnya.disabled = !halamanSelanjutnya;

        } catch (error) {

            daftarBuku.innerHTML =
                `<tr><td colspan="${bolehKelolaBuku ? 6 : 5}" class="empty">Data buku gagal dimuat.</td></tr>`;

            tampilkanPesan(
                'Tidak dapat mengambil data buku. ' + error.message
            );

        } finally {
            sedangMemuat = false;
        }
    }

    function resetForm() {
        if (!form) return;

        form.reset();
        bukuId.value = '';
        judulForm.textContent = 'Tambah Buku';
        btnSimpan.textContent = 'Simpan Buku';
        btnBatal.hidden = true;
    }

    async function editBuku(id) {

        if (!bolehKelolaBuku || !form) return;

        sembunyikanPesan();

        try {
            const response = await fetch(`${API}/${id}`, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            const hasil = await bacaRespons(response);
            const buku = hasil.data;

            if (!buku) {
                throw new Error('Data buku tidak ditemukan.');
            }

            bukuId.value = buku.id;

            kategoriInput.value =
                buku.kategori_id ?? buku.kategori?.id ?? '';

            judulInput.value = buku.judul ?? '';
            penulisInput.value = buku.penulis ?? '';
            tahunInput.value = buku.tahun_terbit ?? buku.tahun ?? '';

            judulForm.textContent = 'Edit Buku';
            btnSimpan.textContent = 'Simpan Perubahan';
            btnBatal.hidden = false;

            form.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        } catch (error) {

            tampilkanPesan(
                'Gagal mengambil data buku: ' + error.message
            );
        }
    }

    // SOAL 3: PROSES TAMBAH DAN UBAH BUKU.
    if (form) {

        form.addEventListener('submit', async (event) => {

            event.preventDefault();
            sembunyikanPesan();

            const id = bukuId.value;

            const dataBuku = {
                kategori_id: Number(kategoriInput.value),
                judul: judulInput.value.trim(),
                penulis: penulisInput.value.trim(),
                tahun_terbit: Number(tahunInput.value)
            };

            btnSimpan.disabled = true;
            btnSimpan.textContent = 'Menyimpan...';

            try {
                const response = await fetch(id ? `${API}/${id}` : API, {
                    method: id ? 'PUT' : 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(dataBuku)
                });

                const hasil = await bacaRespons(response);

                resetForm();

                tampilkanPesan(
                    hasil.message ||
                    (
                        id
                            ? 'Buku berhasil diperbarui.'
                            : 'Buku berhasil ditambahkan.'
                    ),
                    'sukses'
                );

                await muatBuku();

            } catch (error) {

                tampilkanPesan(
                    'Gagal menyimpan buku: ' + error.message
                );

            } finally {

                btnSimpan.disabled = false;

                btnSimpan.textContent = bukuId.value
                    ? 'Simpan Perubahan'
                    : 'Simpan Buku';
            }
        });
    }

    // SOAL 3: PENGHAPUSAN BUKU MENGGUNAKAN CSRF DAN METODE DELETE.
    async function hapusBuku(buku) {

        if (!bolehKelolaBuku || !formHapus) return;

        if (!confirm(
            `Apakah kamu yakin ingin menghapus buku "${buku.judul}"?`
        )) return;

        sembunyikanPesan();

        try {
            const response = await fetch(`/buku/${buku.id}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: new FormData(formHapus)
            });

            const hasil = await bacaRespons(response);

            if (bukuId && bukuId.value === String(buku.id)) {
                resetForm();
            }

            tampilkanPesan(
                hasil.message || 'Buku berhasil dihapus.',
                'sukses'
            );

            await muatBuku();

        } catch (error) {

            tampilkanPesan(
                'Gagal menghapus buku: ' + error.message
            );
        }
    }

    if (btnBatal) {
        btnBatal.addEventListener('click', () => {
            resetForm();
            sembunyikanPesan();
        });
    }

    btnSebelumnya.addEventListener('click', () => {
        if (halamanSebelumnya) {
            muatBuku(halamanSebelumnya);
        }
    });

    btnSelanjutnya.addEventListener('click', () => {
        if (halamanSelanjutnya) {
            muatBuku(halamanSelanjutnya);
        }
    });

    muatBuku();
});
</script>

</body>
</html>
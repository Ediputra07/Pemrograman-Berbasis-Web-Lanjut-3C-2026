@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="page-title">
    <h2>Daftar Buku</h2>
    <p>Tambah, lihat, ubah, dan hapus data buku melalui API.</p>
</div>

<style>
    .api-buku-container {
        width: 100%;
        margin-top: 20px;
    }

    .form-buku {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
    }

    .form-buku label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .form-buku input,
    .form-buku select {
        width: 100%;
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 14px;
    }

    .form-buku .form-actions {
        grid-column: 1 / -1;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn-buku {
        padding: 9px 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        color: white;
        background: #166534;
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

    .table-buku-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .table-buku {
        width: 100%;
        border-collapse: collapse;
    }

    .table-buku th,
    .table-buku td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-buku th {
        background: #ecfdf5;
    }

    .aksi-buku {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .pesan-buku {
        margin: 12px 0;
        padding: 12px;
        border-radius: 6px;
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

    .pagination-buku {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 16px;
    }

    @media (max-width: 600px) {
        .form-buku {
            grid-template-columns: 1fr;
        }

        .form-buku .form-actions {
            grid-column: auto;
        }
    }
</style>

<div class="api-buku-container">

    <h3 id="judul-form">Tambah Buku</h3>

    <div id="pesan" class="pesan-buku" role="status"
         aria-live="polite" hidden></div>

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

    <h3>Daftar Koleksi Buku</h3>

    <div class="table-buku-wrapper">
        <table class="table-buku">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody id="daftar-buku">
                <tr>
                    <td colspan="6">Memuat data buku...</td>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const API = '/api/buku';

    const form = document.getElementById('form-buku');
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
                const detail = Object.values(data.errors)
                    .flat()
                    .join(' ');

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
            '<tr><td colspan="6">Memuat data buku...</td></tr>';

        btnSebelumnya.disabled = true;
        btnSelanjutnya.disabled = true;

        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const hasil = await bacaRespons(response);

            const bukus = Array.isArray(hasil.data)
                ? hasil.data
                : [];

            halamanSebelumnya = hasil.links?.prev || null;
            halamanSelanjutnya = hasil.links?.next || null;

            const halaman = hasil.meta?.current_page ?? 1;
            const halamanAkhir = hasil.meta?.last_page ?? 1;
            const nomorAwal = hasil.meta?.from ?? 1;

            daftarBuku.replaceChildren();

            if (bukus.length === 0) {
                const baris = document.createElement('tr');
                const kolom = document.createElement('td');

                kolom.colSpan = 6;
                kolom.textContent = 'Belum ada data buku.';

                baris.appendChild(kolom);
                daftarBuku.appendChild(baris);
            } else {
                bukus.forEach((buku, index) => {
                    const baris = document.createElement('tr');

                    const nilai = [
                        nomorAwal + index,
                        buku.kategori ?? '-',
                        buku.judul ?? '-',
                        buku.penulis ?? '-',
                        buku.tahun_terbit ?? buku.tahun ?? '-'
                    ];

                    nilai.forEach((item) => {
                        const kolom = document.createElement('td');
                        kolom.textContent = String(item);
                        baris.appendChild(kolom);
                    });

                    const kolomAksi = document.createElement('td');
                    const wadahAksi = document.createElement('div');
                    wadahAksi.className = 'aksi-buku';

                    const tombolEdit = document.createElement('button');
                    tombolEdit.type = 'button';
                    tombolEdit.className = 'btn-buku btn-edit';
                    tombolEdit.textContent = 'Edit';
                    tombolEdit.addEventListener('click', () => {
                        editBuku(buku.id);
                    });

                    const tombolHapus = document.createElement('button');
                    tombolHapus.type = 'button';
                    tombolHapus.className = 'btn-buku btn-hapus';
                    tombolHapus.textContent = 'Hapus';
                    tombolHapus.addEventListener('click', () => {
                        hapusBuku(buku);
                    });

                    wadahAksi.append(tombolEdit, tombolHapus);
                    kolomAksi.appendChild(wadahAksi);
                    baris.appendChild(kolomAksi);
                    daftarBuku.appendChild(baris);
                });
            }

            infoHalaman.textContent =
                `Halaman ${halaman} dari ${halamanAkhir}`;

            btnSebelumnya.disabled = !halamanSebelumnya;
            btnSelanjutnya.disabled = !halamanSelanjutnya;

        } catch (error) {
            daftarBuku.innerHTML =
                '<tr><td colspan="6">Data buku gagal dimuat.</td></tr>';

            tampilkanPesan(
                'Tidak dapat mengambil data buku. ' + error.message
            );
        } finally {
            sedangMemuat = false;
        }
    }

    function resetForm() {
        form.reset();
        bukuId.value = '';
        judulForm.textContent = 'Tambah Buku';
        btnSimpan.textContent = 'Simpan Buku';
        btnBatal.hidden = true;
    }

    async function editBuku(id) {
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
            kategoriInput.value = buku.kategori_id ?? '';
            judulInput.value = buku.judul ?? '';
            penulisInput.value = buku.penulis ?? '';
            tahunInput.value =
                buku.tahun_terbit ?? buku.tahun ?? '';

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

        const url = id ? `${API}/${id}` : API;
        const method = id ? 'PUT' : 'POST';

        btnSimpan.disabled = true;
        btnSimpan.textContent = 'Menyimpan...';

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(dataBuku)
            });

            const hasil = await bacaRespons(response);

            resetForm();

            tampilkanPesan(
                hasil.message || (
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
        }
    });

    async function hapusBuku(buku) {
        const setuju = confirm(
            `Apakah kamu yakin ingin menghapus buku "${buku.judul}"?`
        );

        if (!setuju) return;

        sembunyikanPesan();

        try {
            const response = await fetch(`${API}/${buku.id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const hasil = await bacaRespons(response);

            if (bukuId.value === String(buku.id)) {
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

    btnBatal.addEventListener('click', () => {
        resetForm();
        sembunyikanPesan();
    });

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
@endsection


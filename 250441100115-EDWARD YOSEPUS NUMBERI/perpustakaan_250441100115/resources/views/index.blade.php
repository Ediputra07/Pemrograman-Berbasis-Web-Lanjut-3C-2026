@extends('layouts.app') <!-- Sesuaikan dengan layout utama Laravel kamu jika ada -->

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Manajemen Data Buku (RESTful API)</h2>

    <!-- Form Tambah / Ubah Buku -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 id="form-title" class="mb-3">Tambah Buku Baru</h4>
            <form id="buku-form">
                <!-- ID Hidden untuk mode Ubah (Sangat penting agar tidak error 404 / data tidak ditemukan) -->
                <input type="hidden" id="buku-id">

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">ID Kategori</label>
                    <input type="text" class="form-control" id="kategori_id" required>
                </div>
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" id="judul" required>
                </div>
                <div class="mb-3">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" required>
                </div>
                <div class="mb-3">
                    <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" id="tahun_terbit" min="1900" max="2026" required>
                </div>

                <button type="submit" class="btn btn-dark">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Buku -->
    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">Daftar Buku Perpustakaan</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 20%;">Kategori</th>
                            <th style="width: 30%;">Judul Buku</th>
                            <th style="width: 20%;">Penulis</th>
                            <th style="width: 10%;">Tahun</th>
                            <th style="width: 15%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="buku-table-body">
                        <!-- Data dari JavaScript akan dirender di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- CSRF Token untuk keamanan Fetch API -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    const API_URL = '/api/buku'; // Sesuaikan dengan routes/api.php kamu (misal: '/api/bukus' jika pakai 's')

    // 1. Fungsi Memuat Data Buku ke Tabel
    async function loadBuku() {
        try {
            let response = await fetch(API_URL);
            let result = await response.json();
            
            // Mendukung struktur data API standar maupun yang menggunakan Resource Collection
            let data = Array.isArray(result) ? result : (result.data || []);
            let tbody = document.getElementById('buku-table-body');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Belum ada data buku.</td></tr>`;
                return;
            }

            data.forEach((buku, index) => {
                let kategori = buku.kategori?.nama_kategori ?? buku.kategori?.nama ?? buku.kategori_id ?? '-';
                let judul = buku.judul_buku ?? buku.judul ?? '-';
                let penulis = buku.penulis ?? '-';
                let tahun = buku.tahun ?? buku.tahun_terbit ?? '-';

                tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${kategori}</td>
                        <td>${judul}</td>
                        <td>${penulis}</td>
                        <td>${tahun}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-warning btn-sm text-white" onclick="editBuku(${buku.id}, '${buku.kategori_id ?? ''}', '${buku.judul_buku ?? buku.judul ?? ''}', '${buku.penulis ?? ''}', ${buku.tahun ?? buku.tahun_terbit ?? 0})">Ubah</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteBuku(${buku.id})">Hapus</button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        } catch (error) {
            console.error('Gagal memuat data:', error);
        }
    }

    // 2. Fungsi Mengisi Form saat tombol Ubah diklik
    function editBuku(id, kategori_id, judul, penulis, tahun_terbit) {
        document.getElementById('buku-id').value = id;
        document.getElementById('kategori_id').value = kategori_id;
        document.getElementById('judul').value = judul;
        document.getElementById('penulis').value = penulis;
        document.getElementById('tahun_terbit').value = tahun_terbit;
        
        document.getElementById('form-title').innerText = 'Ubah Data Buku';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // 3. Fungsi Reset Form
    function resetForm() {
        let form = document.getElementById('buku-form');
        if (form) form.reset();
        let bukuId = document.getElementById('buku-id');
        if (bukuId) bukuId.value = '';
        
        document.getElementById('form-title').innerText = 'Tambah Buku Baru';
    }

    // 4. Proses Simpan / Perbarui Data (POST / PUT) dengan Validasi & Notifikasi Sukses
    document.getElementById('buku-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        let id = document.getElementById('buku-id').value;
        let kategori_id = document.getElementById('kategori_id').value;
        let judul = document.getElementById('judul').value;
        let penulis = document.getElementById('penulis').value;
        let tahun_terbit = parseInt(document.getElementById('tahun_terbit').value);

        // Validasi Frontend: Tahun tidak boleh lebih dari 2026
        if (tahun_terbit > 2026) {
            alert('Validasi Gagal:\nTahun terbit tidak boleh lebih dari tahun 2026!');
            return;
        }

        // Konfirmasi sebelum memperbarui data
        if (id) {
            if (!confirm('Apakah kamu yakin ingin memperbarui data buku ini?')) {
                return;
            }
        }

        let payload = { kategori_id, judul, penulis, tahun_terbit };
        let url = id ? `${API_URL}/${id}` : API_URL;
        let method = id ? 'PUT' : 'POST';

        try {
            let response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            });

            let result = await response.json();

            // Tangkap error validasi dari Laravel (Status 422)
            if (response.status === 422) {
                let errorMessages = '';
                for (let field in result.errors) {
                    errorMessages += `- ${result.errors[field][0]}\n`;
                }
                alert("Validasi Gagal:\n" + errorMessages);
                return;
            }

            if (!response.ok) {
                throw new Error(result.message || 'Terjadi kesalahan saat menyimpan data.');
            }

            // Tanda Keberhasilan (Alert Sukses)
            if (id) {
                alert('Sukses! Data buku berhasil diperbarui.');
            } else {
                alert('Sukses! Data buku baru berhasil ditambahkan.');
            }

            resetForm();
            loadBuku();

        } catch (error) {
            alert('Kesalahan: ' + error.message);
        }
    });

    // 5. Fungsi Hapus Buku (DELETE)
    async function deleteBuku(id) {
        if (!confirm('Apakah kamu yakin ingin menghapus buku ini?')) {
            return;
        }

        try {
            let response = await fetch(`${API_URL}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            let result = await response.json();
            if (!response.ok) throw new Error(result.message || 'Gagal menghapus data.');

            alert('Sukses! Data buku berhasil dihapus.');
            loadBuku();
        } catch (error) {
            alert('Kesalahan: ' + error.message);
        }
    }

    // Jalankan pemuatan data saat halaman pertama kali dibuka
    document.addEventListener('DOMContentLoaded', loadBuku);
</script>
@endsection
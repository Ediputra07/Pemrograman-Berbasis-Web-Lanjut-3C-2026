const root = document.getElementById('app-buku');
const API = root.dataset.apiUrl;            
const DETAIL_URL = root.dataset.detailUrl; 

const FIELD = ['kategori_id', 'judul', 'penulis', 'tahun_terbit'];
const $ = (id) => document.getElementById(id);

let halaman = 1;            
let sedangMemproses = false; 
let nomorPermintaan = 0;    

/*  Utilitas  */

const esc = (t) => String(t ?? '').replace(/[&<>"']/g, (c) =>
  ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

class ApiError extends Error {
  constructor(status, message, errors = {}) {
    super(message);
    this.name = 'ApiError';
    this.status = status;   
    this.errors = errors;   
  }
}

function pesanDariStatus(status) {
  if (status === 404) return 'Data yang diminta tidak ditemukan.';
  if (status === 422) return 'Data yang dikirim belum valid.';
  if (status >= 500) return `Terjadi kesalahan pada server (HTTP ${status}). Silakan coba lagi nanti.`;
  return `Permintaan gagal diproses (HTTP ${status}).`;
}

function pesan(teks, jenis = 'success') {
  $('alert-area').innerHTML = `<div class="alert alert--${jenis}" role="alert">${esc(teks)}</div>`;
}

const hapusPesan = () => { $('alert-area').innerHTML = ''; };

function bersihkanError() {
  FIELD.forEach((f) => { $(`err-${f}`).textContent = ''; });
}

const detailUrl = (id) => DETAIL_URL.replace('__ID__', encodeURIComponent(id));

/* Satu pintu untuk semua request  */

async function apiRequest(path = '', { method = 'GET', body = null } = {}) {
  const headers = { Accept: 'application/json' };
  if (body !== null) headers['Content-Type'] = 'application/json';

  let response;
  try {
    response = await fetch(API + path, {
      method,
      headers,
      body: body !== null ? JSON.stringify(body) : undefined,
    });
  } catch (err) {
    
    console.error('Gagal menghubungi API:', err);
    throw new ApiError(0, 'Tidak dapat terhubung ke server. Pastikan server aplikasi berjalan, lalu coba lagi.');
  }

  if (response.status === 204) return null; 

  const data = await response.json().catch(() => null);

  
  if (!response.ok) {
    throw new ApiError(response.status, pesanDariStatus(response.status), data?.errors ?? {});
  }
  if (data === null) {
    throw new ApiError(response.status, 'Respons server tidak dapat dibaca. Hubungi pengelola aplikasi.');
  }
  return data;
}

function tanganiError(err) {
  bersihkanError();

  if (!(err instanceof ApiError)) {
    console.error(err);
    pesan('Terjadi kesalahan tak terduga pada halaman.', 'danger');
    return;
  }

  if (err.status === 422) {
 
    Object.entries(err.errors).forEach(([field, daftar]) => {
      const el = $(`err-${field}`);
      if (el) el.textContent = [].concat(daftar).join(' ');
    });
    pesan('Data belum valid. Periksa isian formulir.', 'warning');
  } else if (err.status === 404) {
    pesan('Data buku tidak ditemukan. Mungkin sudah dihapus.', 'warning');
    muatBuku(halaman);
  } else {
    pesan(err.message, 'danger'); 
  }
}



async function muatBuku(page = 1) {
  const nomor = ++nomorPermintaan;
  $('tbody-buku').innerHTML = '<tr><td colspan="6" class="tabel__info">Memuat data...</td></tr>';

  try {
    const json = await apiRequest(`?page=${page}`);
    if (nomor !== nomorPermintaan) return; 

    const { data, meta, links } = json;

    if (data.length === 0 && meta.current_page > meta.last_page) {
      return muatBuku(meta.last_page);
    }

    halaman = meta.current_page;

    $('tbody-buku').innerHTML = data.length
      ? data.map((b, i) => `
          <tr>
            <td>${(meta.from ?? 1) + i}</td>
            <td>${esc(b.kategori)}</td>
            <td><a href="${esc(detailUrl(b.id))}">${esc(b.judul)}</a></td>
            <td>${esc(b.penulis)}</td>
            <td>${esc(b.tahun)}</td>
            <td class="aksi">
              <button type="button" class="tombol tombol--kecil tombol--peringatan" data-aksi="ubah" data-id="${esc(b.id)}">Ubah</button>
              <button type="button" class="tombol tombol--kecil tombol--bahaya" data-aksi="hapus" data-id="${esc(b.id)}">Hapus</button>
            </td>
          </tr>`).join('')
      : '<tr><td colspan="6" class="tabel__info">Belum ada data buku.</td></tr>';

    $('info-halaman').textContent = data.length
      ? `Halaman ${meta.current_page} dari ${meta.last_page} (${meta.total} buku)`
      : '';
    $('btn-prev').disabled = links.prev === null;
    $('btn-next').disabled = links.next === null;
  } catch (err) {
    if (nomor !== nomorPermintaan) return;

    const teks = err instanceof ApiError ? err.message : 'Terjadi kesalahan tak terduga saat menampilkan data.';
    if (!(err instanceof ApiError)) console.error(err);

    $('tbody-buku').innerHTML = `
      <tr><td colspan="6" class="tabel__info tabel__info--galat">
        ${esc(teks)}
        <button type="button" class="tombol tombol--kecil" data-aksi="muat-ulang">Coba lagi</button>
      </td></tr>`;
    $('info-halaman').textContent = '';
    $('btn-prev').disabled = true;
    $('btn-next').disabled = true;
  }
}

/*(tambah / ubah) */

function resetForm() {
  $('form-buku').reset();
  $('buku-id').value = '';
  $('judul-form').textContent = 'Tambah Buku';
  $('btn-simpan').textContent = 'Tambah Buku';
  $('btn-batal').hidden = true;
  bersihkanError();
}

function isiForm(b) {
  bersihkanError();
  $('buku-id').value = b.id;
  $('buku-kategori_id').value = b.kategori_id ?? '';
  $('buku-judul').value = b.judul ?? '';
  $('buku-penulis').value = b.penulis ?? '';
  $('buku-tahun_terbit').value = b.tahun ?? ''; 
  $('judul-form').textContent = 'Ubah Buku';
  $('btn-simpan').textContent = 'Simpan Perubahan';
  $('btn-batal').hidden = false;
  $('form-buku').scrollIntoView({ behavior: 'smooth', block: 'start' });
  $('buku-judul').focus({ preventScroll: true });
}

function setMemproses(aktif) {
  sedangMemproses = aktif;
  const tombol = $('btn-simpan');
  tombol.disabled = aktif;
  tombol.textContent = aktif
    ? 'Menyimpan...'
    : ($('buku-id').value ? 'Simpan Perubahan' : 'Tambah Buku');
}



async function simpan(e) {
  e.preventDefault();
  if (sedangMemproses) return;

  const id = $('buku-id').value;
  const tahun = $('buku-tahun_terbit').value;
  const body = {
    kategori_id: $('buku-kategori_id').value || null,
    judul: $('buku-judul').value.trim(),
    penulis: $('buku-penulis').value.trim(),
    tahun_terbit: tahun === '' ? null : Number(tahun),
  };

  hapusPesan();
  bersihkanError();
  setMemproses(true);

  try {
   
    const hasil = await apiRequest(id ? `/${encodeURIComponent(id)}` : '', {
      method: id ? 'PUT' : 'POST',
      body,
    });
    pesan(hasil?.message ?? (id ? 'Buku berhasil diperbarui.' : 'Buku berhasil ditambahkan.'));
    resetForm();
    await muatBuku(id ? halaman : 1); 
  } catch (err) {
    tanganiError(err);
  } finally {
    setMemproses(false);
  }
}

async function bukaFormUbah(id) {
  if (sedangMemproses) return;
  hapusPesan();
  try {
    const { data } = await apiRequest(`/${encodeURIComponent(id)}`); 
    isiForm(data);
  } catch (err) {
    tanganiError(err);
  }
}

async function hapus(id) {
  if (sedangMemproses) return;
  if (!window.confirm('Hapus buku ini? Tindakan ini tidak dapat dibatalkan.')) return; 

  hapusPesan();
  sedangMemproses = true;
  try {
    const hasil = await apiRequest(`/${encodeURIComponent(id)}`, { method: 'DELETE' });
    pesan(hasil?.message ?? 'Buku berhasil dihapus.');
    if ($('buku-id').value === String(id)) resetForm(); 
    await muatBuku(halaman);
  } catch (err) {
    tanganiError(err);
  } finally {
    sedangMemproses = false;
  }
}

/* Inisialisasi */

document.addEventListener('DOMContentLoaded', () => {
  $('form-buku').onsubmit = simpan;
  $('btn-batal').onclick = resetForm;
  $('btn-prev').onclick = () => muatBuku(halaman - 1);
  $('btn-next').onclick = () => muatBuku(halaman + 1);

 
  $('tbody-buku').onclick = (e) => {
    const tombol = e.target.closest('button[data-aksi]');
    if (!tombol) return;
    const { aksi, id } = tombol.dataset;
    if (aksi === 'hapus') hapus(id);
    else if (aksi === 'ubah') bukaFormUbah(id);
    else if (aksi === 'muat-ulang') muatBuku(halaman);
  };

  muatBuku(1);
});

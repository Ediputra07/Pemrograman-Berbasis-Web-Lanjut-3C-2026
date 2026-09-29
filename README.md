# 🚀 Repositori Praktikum Pemrograman Berbasis Web Lanjut - 3C - 2026

Selamat datang di repositori resmi praktikum **Pemrograman Berbasis Web Lanjut (PBWL) Kelas 3C**. Repositori ini digunakan oleh seluruh mahasiswa untuk mengumpulkan penugasan praktikum berbasis framework **Laravel 13** melalui sistem **Fork & Pull Request (PR)**.

---

## 🛠️ Prasyarat Sistem (Laravel 13 Requirements)

Sebelum menjalankan proyek, pastikan perangkat lokal Anda telah memenuhi prasyarat **Laravel 13**:
- **PHP**: `>= 8.3` (Disarankan PHP 8.3 atau 8.4)
- **Composer**: `>= 2.2.0`
- **Node.js & NPM**: `>= 18.x` / `>= 20.x`
- **Database**: MySQL / MariaDB / SQLite

---

## 📌 Aturan Praktikum & Larangan

1. **Satu Proyek Per Mahasiswa**: Setiap folder mahasiswa (berformat `{NIM}-{NAMA LENGKAP}`) merupakan **satu proyek Laravel**. Tidak perlu membuat subfolder per modul di dalamnya.
2. **Format Commit Message (WAJIB)**:
   Pengerjaan setiap modul ditandai melalui format pesan commit sebagai berikut:
   ```text
   NIM_NamaLengkap_MODUL<X>_NamaAsprak
   ```
   **Contoh Commit:**
   `240441100057_OktaviaPutriRoichatulJannah_MODUL1_KakSalman`

3. **File yang Dilarang Diumpan ke Git (Git Ignore)**:
   - ❌ **DILARANG** meng-push folder `vendor/`
   - ❌ **DILARANG** meng-push folder `node_modules/`
   - ❌ **DILARANG** meng-push file `.env`
   - ✅ Root `.gitignore` dan `.gitignore` lokal akan otomatis mencegah file ini ter-push.

4. **Integritas Repositori**:
   - Mahasiswa **HANYA BOLEH** mengedit dan meng-push file di dalam folder milik sendiri.
   - **Dilarang** mengedit folder mahasiswa lain atau file root (`README.md`, `.github/`, dll). PR yang melanggar akan otomatis ditolak oleh sistem CI.

---

## 📂 Struktur Direktori Repositori

```text
Pemrograman-Berbasis-Web-Lanjut-3C-2026/
├── 250441100001-SULTAN/                <-- Proyek Laravel Utama Mahasiswa
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── tests/
│   ├── .gitignore
│   ├── composer.json
│   └── ...
├── 250441100006-MOHAMMAD IRFAN HARIYONO/
└── ... (folder mahasiswa lainnya)
```

---

## 💻 Panduan Git Workflow (Fork & Pull Request)

Seluruh pengumpulan tugas praktikum dilakukan menggunakan skema **Fork & Pull Request**:

### 1. Fork Repositori
- Buka repositori utama ini di GitHub.
- Klik tombol **Fork** di pojok kanan atas untuk membuat salinan repositori di akun GitHub Anda masing-masing.

### 2. Clone Repositori Hasil Fork
Clone repositori dari akun GitHub Anda sendiri:
```bash
git clone https://github.com/[USERNAME_GITHUB_ANDA]/Pemrograman-Berbasis-Web-Lanjut-3C-2026.git
cd Pemrograman-Berbasis-Web-Lanjut-3C-2026
```

### 3. Masuk ke Folder Anda & Kerjakan Tugas
```bash
cd 2504411000XX-NAMA MAHASISWA
```
Kerjakan tugas modul terkait di dalam folder proyek Laravel Anda.

### 4. Commit dengan Format Resmi & Push ke Fork
Setelah selesai mengerjakan modul:
```bash
# 1. Tambahkan perubahan di folder Anda
git add .

# 2. Commit dengan format WAJIB (NIM_NamaLengkap_MODUL<X>_NamaAsprak)
git commit -m "240441100057_OktaviaPutriRoichatulJannah_MODUL1_KakSalman"

# 3. Push ke repositori Fork milik Anda
git push origin main
```

### 5. Buat Pull Request (PR) ke Repositori Utama
1. Buka repositori hasil Fork Anda di GitHub.
2. Klik tombol **Contribute** -> **Open Pull Request**.
3. Pastikan **Base Repository** mengarah ke `main` di repositori utama praktikum.
4. Berikan Judul PR yang jelas (contoh: `NIM_NamaLengkap_MODUL<X>_NamaAsprak`).
5. Klik **Create Pull Request**.

> 🤖 **Sistem GitHub Actions (CI) akan otomatis mengecek PR Anda:**
> - ✅ Memeriksa apakah Anda hanya mengubah folder milik Anda sendiri.
> - ✅ Memeriksa apakah format pesan commit Anda sudah benar.
> - ✅ Memeriksa apakah ada sintaks PHP yang error.

---

## ⚡ Cara Menjalankan Proyek Laravel 13 (Untuk Asprak)

Jika Asisten Praktikum ingin mengecek atau menguji proyek milik mahasiswa:

1. Masuk ke direktori mahasiswa yang dituju:
   ```bash
   cd 2504411000XX-NAMA MAHASISWA
   ```
2. Install dependensi PHP (Composer) & Frontend (NPM):
   ```bash
   composer install
   npm install && npm run build
   ```
3. Salin file `.env` & Generate Application Key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Jalankan Migrasi Database & Seeder:
   ```bash
   php artisan migrate --seed
   ```
5. Menjalankan Server Development:
   ```bash
   php artisan serve
   ```

---

## 🙋‍♂️ Daftar Asisten Praktikum

Gunakan nama panggilan Asprak di bawah ini saat melakukan commit:

| No | Nama Lengkap Asprak | Nama Panggilan Commit (`NamaAsprak`) |
|:--:|:--------------------|:------------------------------------|
| 1  | Oktavia Putri Roichatul Jannah          | `KakOkta`                         |
| 2  | Destya Nurfaiza Muslim          | `KakDestya`                     |
| 3  | Edi Putra          | `KakEdi`                     |

---

*Jika mengalami kendala teknis atau konflik Git saat melakukan PR, segera hubungi Asisten Praktikum.*
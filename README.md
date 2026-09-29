# Repositori Praktikum Pemrograman Berbasis Web Lanjut- 3C - 2026

Selamat datang di repositori resmi praktikum **Pemrograman Berbasis Web Lanjut (PBWL) Kelas 3C**. Repositori ini digunakan oleh seluruh mahasiswa untuk mengumpulkan penugasan praktikum yang dibangun menggunakan framework **Laravel 13**.

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
2. **Format Commit Message (Wajib)**:
   Pengerjaan setiap modul ditandai melalui format pesan commit sebagai berikut:
   ```text
   NIM_NamaLengkap_MODUL<X>_NamaAsprak
   ```
   **Contoh:**
   `240441100057_OktaviaPutriRoichatulJannah_MODUL1_KakSalman`

3. **File yang Dilarang Diumpan ke Git (Git Ignore)**:
   - ❌ **DILARANG** meng-push folder `vendor/`
   - ❌ **DILARANG** meng-push folder `node_modules/`
   - ❌ **DILARANG** meng-push file `.env`
   - ✅ Pastikan `.gitignore` bawaan Laravel aktif di dalam folder Anda.

4. **Integritas Repositori**: Mahasiswa **HANYA BOLEH** mengedit dan meng-push file di dalam folder milik sendiri. Dilarang mengubah folder mahasiswa lain maupun file di luar folder Anda.

---

## 📂 Struktur Direktori Repositori

```text
Pemrograman-Berbasis-Web-Lanjut-3C-2026/
├── 250441100001-SULTAN/                <-- Langsung berupa Proyek Laravel
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

## 💻 Panduan Git Workflow (Cara Push Tugas Modul)

### 1. Clone & Update Repositori
Lakukan `pull` terlebih dahulu sebelum melakukan pengerjaan/commit baru:
```bash
git clone https://github.com/WargaLab-Information-Systems/Pemrograman-Berbasis-Web-Lanjut-3C-2026.git
cd Pemrograman-Berbasis-Web-Lanjut-3C-2026
git pull origin main
```

### 2. Masuk ke Folder Anda & Kerjakan Tugas
```bash
cd 2504411000XX-NAMA MAHASISWA
```

### 3. Tahap Commit dan Push Modul
Setelah selesai mengerjakan modul terkait:

```bash
# 1. Tambahkan HANYA folder Anda sendiri
git add .

# 2. Lakukan Commit sesuai format modul & asprak
git commit -m "240441100057_OktaviaPutriRoichatulJannah_MODUL1_KakSalman"

# 3. Pull terlebih dahulu untuk update perubahan dari repositori
git pull origin main --rebase

# 4. Push ke GitHub
git push origin main
```

---

## ⚡ Cara Menjalankan Proyek Laravel 13 (Untuk Penguji / Asprak)

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

## 🙋‍♂️ Daftar Asisten Praktikum (Asprak)

Gunakan nama panggilan Asprak di bawah ini saat melakukan commit:

| No | Nama Lengkap Asprak | Nama Panggilan Commit (`NamaAsprak`) |
|:--:|:--------------------|:------------------------------------|
| 1  | Oktavia Putri Roichatul Jannah          | `KakOkta`                         |
| 2  | Destya Nurfaiza Muslim     | `KakDestya`                     |
| 3  | Edi Putra     | `KakEdi`                     |

---

*Jika mengalami kendala teknis atau konflik Git, segera hubungi Asisten Praktikum.*
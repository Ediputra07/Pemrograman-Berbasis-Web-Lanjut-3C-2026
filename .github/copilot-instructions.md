# Instruksi Agen AI - Praktikum Pemrograman Berbasis Web Lanjut (PBWL) 3C

Repositori ini adalah monorepo penugasan praktikum mahasiswa berbasis Laravel 13 dan PHP 8.3/8.4 di bawah organisasi WargaLab Information Systems.

## 1. Aturan Struktur Direktori
- Setiap direktori di tingkat root yang berformat `{12_DIGIT_NIM}-{NAMA_LENGKAP}` adalah satu proyek aplikasi Laravel mandiri milik mahasiswa.
- Jangan pernah menyarankan perubahan pada file di root direktori (seperti `README.md`, file konfigurasi Git, atau direktori `.github/workflows/`).
- Jangan pernah menyarankan modifikasi file pada folder milik mahasiswa lain.

## 2. Standar Kode dan Arsitektur
- Framework: Laravel 13.
- Bahasa: PHP >= 8.3 dengan deklarasi tipe data yang ketat (`declare(strict_types=1);` jika relevan).
- Standar Penulisan: Ikuti pedoman PSR-12 dan konvensi penamaan resmi Laravel (Controller, Model, Migration, Form Request, Seeder).
- Database: Gunakan Migration dan Eloquent ORM. Hindari penulisan raw SQL tanpa parameter binding.

## 3. Batasan Keamanan dan Pengumpulan
- Jangan sertakan kredensial sensitif pada file konfigurasi. Kredensial lokal harus menggunakan file `.env.example`.
- Jangan menyarankan penambahan atau pembuatan file database lokal (`.sqlite`, `.db`) ke dalam Git staging.
- Pastikan seluruh rute dan controller memiliki validasi request yang sesuai.
- Format pesan commit wajib mengikuti pola: `NIM_NamaLengkap_MODUL<X>_NamaAsprak`.

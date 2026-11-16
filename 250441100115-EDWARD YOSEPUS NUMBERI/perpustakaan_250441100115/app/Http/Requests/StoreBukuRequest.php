<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat request ini.
     */
    public function authorize(): bool
    {
        return true; // Diizinkan untuk memproses request API
    }

    /**
     * Aturan validasi yang berlaku untuk request ini.
     */
    public function rules(): array
    {
        return [
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|min:3|max:255',
            'penulis'       => 'required|string|min:3|max:255',
            // Batasi tahun terbit dari rentang 1900 sampai 2026
            'tahun_terbit' => 'required|integer|between:1900,2026'
        ];
    }

    /**
     * Pesan kesalahan validasi kustom dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'kategori_id.required'  => 'Kategori buku wajib dipilih.',
            'kategori_id.exists'    => 'Kategori buku yang dipilih tidak valid.',
            'judul.required'        => 'Judul buku wajib diisi.',
            'judul.min'             => 'Judul buku minimal harus 3 karakter.',
            'penulis.required'      => 'Nama penulis wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka.',
            // Pesan error kustom sesuai dengan tabel pengujian Anda
            'tahun_terbit.between'  => 'Tahun terbit harus antara 1900 sampai 2026',
        ];
    }
}
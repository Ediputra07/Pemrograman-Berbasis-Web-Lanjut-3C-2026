<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBukuRequest extends FormRequest
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
            'penulis'      => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|digits:4',
        ];
    }

    /**
     * Pesan kesalahan validasi kustom dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'kategori_id.required'  => 'Kategori buku wajib dipilih.',
            'kategori_id.exists'    => 'Kategori buku yang dipilih tidak valid di dalam database.',
            'judul.required'        => 'Judul buku wajib diisi.',
            'judul.string'          => 'Judul buku harus berupa teks.',
            'judul.min'             => 'Judul buku minimal harus 3 karakter.',
            'judul.max'             => 'Judul buku maksimal 255 karakter.',
            'penulis.required'      => 'Nama penulis wajib diisi.',
            'penulis.string'        => 'Nama penulis harus berupa teks.',
            'penulis.max'           => 'Nama penulis maksimal 255 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.digits'   => 'Tahun terbit harus terdiri dari 4 digit angka.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|min:3|max:150',
            'penulis' => 'required|string|min:3|max:100',
            'tahun_terbit' => 'required|integer|between:1900,' . date('Y'),
            'image' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            // Validasi kategori
            'kategori_id.required' => 'Kategori buku wajib dipilih sebelum data buku disimpan.',
            'kategori_id.exists' => 'Kategori buku yang dipilih tidak tersedia. Silakan pilih kategori yang valid.',

            // Validasi judul
            'judul.required' => 'Judul buku wajib diisi agar informasi buku dapat disimpan.',
            'judul.string' => 'Judul buku harus berupa teks yang valid.',
            'judul.min' => 'Judul buku harus terdiri dari minimal 3 karakter.',
            'judul.max' => 'Judul buku tidak boleh melebihi 150 karakter.',

            // Validasi penulis
            'penulis.required' => 'Nama penulis wajib diisi agar informasi buku lengkap.',
            'penulis.string' => 'Nama penulis harus berupa teks yang valid.',
            'penulis.min' => 'Nama penulis harus terdiri dari minimal 3 karakter.',
            'penulis.max' => 'Nama penulis tidak boleh melebihi 100 karakter.',

            // Validasi tahun terbit
            'tahun_terbit.required' => 'Tahun terbit buku wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka bulat, bukan teks atau angka desimal.',
            'tahun_terbit.between' => 'Tahun terbit harus berada dalam rentang 1900 sampai ' . date('Y') . '.',

            // Validasi gambar sampul
            'image.required' => 'Nama file gambar sampul buku wajib diisi.',
            'image.string' => 'Nama file gambar sampul buku harus berupa teks.',
            'image.max' => 'Nama file gambar sampul buku tidak boleh melebihi 255 karakter.',

            // Validasi deskripsi
            'description.string' => 'Deskripsi buku harus berupa teks yang valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id' => 'kategori buku',
            'judul' => 'judul buku',
            'penulis' => 'nama penulis',
            'tahun_terbit' => 'tahun terbit',
            'image' => 'gambar sampul buku',
            'description' => 'deskripsi buku',
        ];
    }
}
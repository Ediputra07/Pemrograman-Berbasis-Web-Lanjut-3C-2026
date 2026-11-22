<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; //
    }

    public function rules(): array
    {
        $tahunSekarang = date('Y');
        return [
            'kategori_id' => 'required|exists:kategoris,id', //
            'judul' => 'required|string|min:3|max:150', //[cite: 2]
            'penulis' => 'required|string|min:3|max:100', //[cite: 2]
            'tahun_terbit' => "required|integer|between:1900,{$tahunSekarang}", //[cite: 2]
        ];
    }

    public function messages(): array
    {
        $tahunSekarang = date('Y');
        return [
            'kategori_id.required' => 'Kategori wajib diisi.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.', //
            'judul.required' => 'Judul buku wajib diisi.',
            'judul.string' => 'Judul buku harus berupa teks.', //
            'judul.min' => 'Judul buku minimal 3 karakter.', //[cite: 4]
            'judul.max' => 'Judul buku maksimal 150 karakter.',
            'penulis.required' => 'Penulis wajib diisi.',
            'penulis.string' => 'Penulis harus berupa teks.',
            'penulis.min' => 'Penulis minimal 3 karakter.',
            'penulis.max' => 'Penulis maksimal 100 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa bilangan bulat.',
            'tahun_terbit.between' => "Tahun terbit harus antara 1900 sampai {$tahunSekarang}.", //[cite: 4]
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id' => 'kategori', //[cite: 2]
            'tahun_terbit' => 'tahun terbit', //[cite: 2]
        ];
    }
}

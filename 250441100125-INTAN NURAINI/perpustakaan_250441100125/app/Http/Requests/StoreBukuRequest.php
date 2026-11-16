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
            'kategori_id' => [
                'required',
                'exists:kategoris,id',
            ],
            'judul' => [
                'required',
                'string',
                'min:3',
                'max:150',
            ],
            'penulis' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'tahun_terbit' => [
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_id.required' =>
                'Kategori wajib dipilih.',
            'kategori_id.exists' =>
                'Kategori yang dipilih tidak tersedia.',

            'judul.required' =>
                'Judul buku wajib diisi.',
            'judul.string' =>
                'Judul buku harus berupa teks.',
            'judul.min' =>
                'Judul buku minimal 3 karakter.',
            'judul.max' =>
                'Judul buku maksimal 150 karakter.',

            'penulis.required' =>
                'Nama penulis wajib diisi.',
            'penulis.string' =>
                'Nama penulis harus berupa teks.',
            'penulis.min' =>
                'Nama penulis minimal 3 karakter.',
            'penulis.max' =>
                'Nama penulis maksimal 100 karakter.',

            'tahun_terbit.required' =>
                'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' =>
                'Tahun terbit harus berupa bilangan bulat.',
            'tahun_terbit.min' =>
                'Tahun terbit minimal tahun 1900.',
            'tahun_terbit.max' =>
                'Tahun terbit tidak boleh melebihi tahun saat ini.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id' => 'kategori',
            'judul' => 'judul buku',
            'penulis' => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}

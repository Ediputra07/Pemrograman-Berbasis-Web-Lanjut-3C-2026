<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Izinkan request
    }

    public function rules(): array
    {
        return [
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|min:3|max:150',
            'penulis' => 'required|string|min:3|max:100',
            'tahun_terbit' => 'required|integer|min:1991|max:' . date('Y'),
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'exists' => ':attribute yang dipilih tidak valid.',
            'string' => ':attribute harus berupa teks.',
            'integer' => ':attribute harus berupa bilangan bulat.',
            'min.string' => ':attribute minimal :min karakter.',
            'max.string' => ':attribute maksimal :max karakter.',
            'min.numeric' => ':attribute minimal harus bernilai :min.',
            'max.numeric' => ':attribute maksimal harus bernilai :max.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id' => 'kategori',
            'judul' => 'judul',
            'penulis' => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}

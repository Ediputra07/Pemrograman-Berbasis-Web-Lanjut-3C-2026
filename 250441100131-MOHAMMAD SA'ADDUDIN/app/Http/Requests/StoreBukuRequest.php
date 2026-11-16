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
           
            'kategori_id'  => ['bail', 'required', 'exists:kategoris,id'],
            'judul'        => ['bail', 'required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['bail', 'required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['bail', 'required', 'integer', 'between:1900,' . now()->year],
        ];
    }

    public function messages(): array
    {
        return [
            
            'required' => ':Attribute wajib diisi.',
            'string'   => ':Attribute harus berupa teks.',
            'integer'  => ':Attribute harus berupa angka bulat.',

            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'judul.min'            => 'Judul buku minimal :min karakter',
            'judul.max'            => 'Judul buku maksimal :max karakter',
            'penulis.min'          => 'Nama penulis minimal :min karakter',
            'penulis.max'          => 'Nama penulis maksimal :max karakter',
            'tahun_terbit.between' => 'Tahun terbit harus antara :min sampai :max',
        ];
    }

 
    public function attributes(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul buku',
            'penulis'      => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}

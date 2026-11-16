<?php

namespace App\Http\Requests;

use App\Http\Requests\StoreBukuRequest;

class UpdateBukuRequest extends StoreBukuRequest
{
    public function rules(): array
    {
        return [
            'kategori_id' => [
                'sometimes',
                'required',
                'exists:kategoris,id',
            ],
            'judul' => [
                'sometimes',
                'required',
                'string',
                'min:3',
                'max:150',
            ],
            'penulis' => [
                'sometimes',
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'tahun_terbit' => [
                'sometimes',
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],
        ];
    }
}

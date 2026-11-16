<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BukuController extends Controller
{
    
    public function index(Request $request): AnonymousResourceCollection
    {
        $buku = Buku::with('kategori')
            ->withCount('peminjaman')
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('judul', 'like', '%' . $request->cari . '%')
                        ->orWhere('penulis', 'like', '%' . $request->cari . '%');
                });
            })
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->kategori))
            ->when($request->filled('tahun'), fn ($q) => $q->where('tahun_terbit', $request->tahun))
            ->latest()
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return BukuResource::collection($buku);
    }

   
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );

        $buku = Buku::create($data);

        return (new BukuResource($buku->load('kategori')->loadCount('peminjaman')))
            ->additional(['message' => 'Buku berhasil ditambahkan'])
            ->response()
            ->setStatusCode(201);
    }

      
    public function show(Buku $buku): BukuResource
    {
        return new BukuResource($buku->load('kategori')->loadCount('peminjaman'));
    }

    
    public function update(Request $request, Buku $buku): JsonResponse
    {
        $data = $request->validate(
            $this->rules(sebagian: true),
            $this->messages(),
            $this->attributes()
        );

        $buku->update($data);

        return (new BukuResource($buku->load('kategori')->loadCount('peminjaman')))
            ->additional(['message' => 'Buku berhasil diperbarui'])
            ->response();
    }

    
    public function destroy(Buku $buku): JsonResponse
    {
        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus',
        ]);
    }

    
    private function rules(bool $sebagian = false): array
    {
        $rules = [
            'kategori_id'  => ['bail', 'required', 'exists:kategoris,id'],
            'judul'        => ['bail', 'required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['bail', 'required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['bail', 'required', 'integer', 'between:1900,' . now()->year],
        ];

        if ($sebagian) {
            $rules = array_map(fn (array $rule) => ['sometimes', ...$rule], $rules);
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi.',
            'string'   => ':Attribute harus berupa teks.',
            'integer'  => ':Attribute harus berupa angka bulat.',

            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'judul.min'            => 'Judul buku minimal :min karakter.',
            'judul.max'            => 'Judul buku maksimal :max karakter.',
            'penulis.min'          => 'Nama penulis minimal :min karakter.',
            'penulis.max'          => 'Nama penulis maksimal :max karakter.',
            'tahun_terbit.between' => 'Tahun terbit harus antara :min sampai :max.',
        ];
    }

    private function attributes(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul buku',
            'penulis'      => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}

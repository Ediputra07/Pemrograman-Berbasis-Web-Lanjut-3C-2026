<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();

        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class)->ignore($user->id),
                Rule::unique('anggotas', 'email')->ignore($user->anggota?->id),
            ],
            'no_telepon' => ['required', 'string', 'regex:/^08[0-9]{8,12}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'         => ':Attribute wajib diisi.',
            'max'              => ':Attribute maksimal :max karakter.',
            'email'            => 'Format email tidak valid.',
            'lowercase'        => 'Email harus ditulis dengan huruf kecil.',
            'email.unique'     => 'Email ini sudah dipakai.',
            'no_telepon.regex' => 'No. telepon harus diawali 08 dan berisi 10-14 angka.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'       => 'nama',
            'email'      => 'email',
            'no_telepon' => 'no. telepon',
        ];
    }
}

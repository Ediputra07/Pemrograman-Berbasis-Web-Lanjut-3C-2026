<?php

namespace App\Http\Requests;


class UpdateBukuRequest extends StoreBukuRequest
{
    public function rules(): array
    {
       
        return collect(parent::rules())
            ->map(fn (array $rule) => ['sometimes', ...$rule])
            ->all();
    }
}

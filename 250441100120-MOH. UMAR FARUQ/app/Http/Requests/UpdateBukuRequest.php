<?php

namespace App\Http\Requests;

class UpdateBukuRequest extends StoreBukuRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool 
    {
        return true;
        
    }

    // Karena meng-extends StoreBukuRequest, rules, messages, dan attributes 
    // akan otomatis mewarisi dari StoreBukuRequest tanpa perlu ditulis ulang[cite: 2].
}

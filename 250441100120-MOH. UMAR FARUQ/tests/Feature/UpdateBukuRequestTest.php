<?php

namespace Tests\Feature;

use App\Http\Requests\UpdateBukuRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateBukuRequestTest extends TestCase
{
    public function test_update_accepts_a_valid_partial_payload(): void
    {
        $validator = Validator::make(
            ['judul' => 'Judul baru'],
            (new UpdateBukuRequest())->rules(),
        );

        $this->assertFalse($validator->fails());
    }
}

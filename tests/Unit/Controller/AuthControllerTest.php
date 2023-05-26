<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_unit() {
        $user = User::factory()->create();

        $token = auth('api')->attempt([
            'email' => $user->email,
            'password' => Hash::make('password')
        ]);

        $this->withHeaders(
            array_merge([
                $this->defaultHeaders,
                ['Authorization' => 'Bearer ' . $token]
            ])
        );

        $this->assertTrue(true);
    }
}

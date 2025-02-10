<?php

namespace Feature\Auth;

use App\Models\User;
use Tests\TestCase;

/**
 * @internal
 */
class LoginTest extends TestCase
{
    public function test_should_login_ok(): void
    {
        $user = User::factory()->create();

        $response = $this->post('api/auth/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertSuccessful();

        $response->assertExactJsonStructure([
            'access_token',
            'access_expires_at',
            'refresh_token',
        ]);
    }
}

<?php

namespace Feature\Auth;

use App\Models\User;
use Str;
use Tests\TestCase;

/**
 * @internal
 */
class LogoutTest extends TestCase
{
    public function test_should_logout_successfully(): void
    {
        $user = User::factory()->create();

        $refreshToken = Str::random(60);

        $user->refreshToken()->delete();

        $user->refreshToken()->create([
            'name'      => 'refresh_token',
            'token'     => $refreshToken,
            'abilities' => ['*'],
        ]);

        $response = $this->post('api/auth/refresh', [
            'refresh_token' => $refreshToken,
        ]);

        $response->assertSuccessful();

        $accessToken = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])
            ->delete('api/auth/logout');

        $response->assertSuccessful();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'token' => $accessToken,
        ]);
    }
}

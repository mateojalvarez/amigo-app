<?php

namespace Feature\Auth;

use App\Models\User;
use Str;
use Tests\TestCase;

/**
 * @internal
 */
class RefreshAuthTest extends TestCase
{
    public function test_should_refresh_auth_successfully(): void
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

        $response->assertExactJsonStructure([
            'access_token',
            'access_expires_at',
            'refresh_token',
        ]);
    }
}

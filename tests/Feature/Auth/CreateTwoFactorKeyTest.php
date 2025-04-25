<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

/**
 * @internal
 */
class CreateTwoFactorKeyTest extends TestCase
{
    public function test_should_create_two_factor_auth_key_successfully(): void
    {
        $response = $this->withAuthenticatedHeaders()->get('api/auth/2fa');

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'secret_key',
            'qr_code',
        ]);
    }
}

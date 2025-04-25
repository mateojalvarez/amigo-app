<?php

namespace Tests\Feature\Auth;

use App\Models\TwoFactorAuthKey;
use App\Models\User;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

/**
 * @internal
 */
class VerifyTwoFactorCodeTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_should_get_successful_response(): void
    {
        $google2faMock = $this->mock(Google2FA::class);

        $google2faMock->shouldReceive('verifyKey')
            ->andReturn(true);

        TwoFactorAuthKey::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->withAuthenticatedHeaders($this->user)->post('api/auth/2fa/verify', [
            'code' => 889923,
        ]);

        $response->assertSuccessful();
    }

    public function test_should_get_authentication_fail_exception(): void
    {
        $google2faMock = $this->mock(Google2FA::class);

        $google2faMock->shouldReceive('verifyKey')
            ->andReturn(false);

        TwoFactorAuthKey::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->withAuthenticatedHeaders($this->user)->post('api/auth/2fa/verify', [
            'code' => 889923,
        ]);

        $response->assertUnauthorized();
    }
}

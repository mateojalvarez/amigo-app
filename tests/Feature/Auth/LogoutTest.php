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
        $response = $this->withAuthenticatedHeaders()
            ->delete('api/auth/logout');

        $response->assertSuccessful();
    }
}

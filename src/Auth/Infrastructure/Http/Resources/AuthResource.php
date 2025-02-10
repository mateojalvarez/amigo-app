<?php

namespace Src\Auth\Infrastructure\Http\Resources;

use Src\Auth\Domain\ValueObjects\Auth;

class AuthResource
{
    public static function toArray(Auth $token): array
    {
        return [
            'access_token'      => $token->getAccessToken()->value(),
            'access_expires_at' => $token->getAccessToken()->expiresAt()->toDateTimeString(),
            'refresh_token'     => $token->getRefreshToken()->value(),
        ];
    }
}

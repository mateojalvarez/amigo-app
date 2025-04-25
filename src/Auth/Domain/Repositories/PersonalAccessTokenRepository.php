<?php

namespace Src\Auth\Domain\Repositories;

use Src\Auth\Domain\ValueObjects\Token;

interface PersonalAccessTokenRepository
{
    public function isVerified(Token $token): bool;

    public function setAsVerified(Token $token): void;
}

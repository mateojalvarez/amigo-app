<?php

namespace Src\Auth\Domain\ValueObjects;

use Carbon\Carbon;

readonly class AccessToken
{
    public function __construct(
        private string $value,
        private Carbon $expiresAt,
        private ?Carbon $verifiedAt = null,
    ) {}

    public function value(): string
    {
        return $this->value;
    }

    public function expiresAt(): Carbon
    {
        return $this->expiresAt;
    }
}

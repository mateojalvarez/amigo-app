<?php

namespace Src\Auth\Domain\ValueObjects;

class TwoFactorAuthKey
{
    private TwoFactorAuthQR $twoFactorAuthQR;

    public function __construct(
        private readonly User $user,
        private readonly string $secret
    ) {}

    public function getUserId(): int
    {
        return $this->user->getId();
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getTwoFactorAuthQR(): TwoFactorAuthQR
    {
        return $this->twoFactorAuthQR;
    }

    public function setTwoFactorAuthQR(TwoFactorAuthQR $twoFactorAuthQR): void
    {
        $this->twoFactorAuthQR = $twoFactorAuthQR;
    }
}

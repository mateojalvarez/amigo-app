<?php

namespace Src\Auth\Infrastructure\Http\Resources;

use Src\Auth\Domain\ValueObjects\TwoFactorAuthKey;

readonly class TwoFactorKeyResource
{
    public function __construct(
        private TwoFactorAuthKey $twoFactorAuthKey
    ) {}

    public function toArray(): array
    {
        return [
            'secret_key' => $this->twoFactorAuthKey->getSecret(),
            'qr_code'    => $this->twoFactorAuthKey->getTwoFactorAuthQR()->value(),
        ];
    }
}

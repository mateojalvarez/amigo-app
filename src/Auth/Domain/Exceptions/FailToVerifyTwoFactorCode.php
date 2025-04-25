<?php

namespace Src\Auth\Domain\Exceptions;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class FailToVerifyTwoFactorCode extends BaseException
{
    public function __construct()
    {
        parent::__construct(
            'two_factor_auth.authentication_fail',
            StatusCodeEnum::UNAUTHORIZED->value
        );
    }
}

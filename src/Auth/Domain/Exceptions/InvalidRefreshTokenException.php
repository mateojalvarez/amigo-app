<?php

namespace Src\Auth\Domain\Exceptions;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class InvalidRefreshTokenException extends BaseException
{
    public function __construct()
    {
        parent::__construct('auth.invalid_refresh_token', StatusCodeEnum::UNAUTHORIZED->value);
    }
}

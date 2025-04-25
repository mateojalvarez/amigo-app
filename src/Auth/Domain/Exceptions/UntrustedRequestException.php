<?php

namespace Src\Auth\Domain\Exceptions;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class UntrustedRequestException extends BaseException
{
    public function __construct()
    {
        parent::__construct('auth.untrusted_request', StatusCodeEnum::UNAUTHORIZED->value);
    }
}

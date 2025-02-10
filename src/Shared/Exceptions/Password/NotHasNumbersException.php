<?php

namespace Src\Shared\Exceptions\Password;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class NotHasNumbersException extends BaseException
{
    public function __construct()
    {
        parent::__construct('password.not_has_numbers', StatusCodeEnum::CONFLICT->value);
    }
}

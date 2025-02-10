<?php

namespace Src\Shared\Exceptions\Password;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class NotHasUpperAndLowerCaseException extends BaseException
{
    public function __construct()
    {
        parent::__construct('password.not_has_upper_and_lower_case', StatusCodeEnum::CONFLICT->value);
    }
}

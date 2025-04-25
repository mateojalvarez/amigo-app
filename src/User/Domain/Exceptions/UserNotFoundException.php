<?php

namespace Src\User\Domain\Exceptions;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class UserNotFoundException extends BaseException
{
    public function __construct()
    {
        parent::__construct('user.user_not_found', StatusCodeEnum::NOT_FOUND->value);
    }
}

<?php

namespace Src\Shared\Exceptions\Password;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class NotHasSpecialCharactersException extends BaseException
{
    public function __construct()
    {
        parent::__construct('password.not_has_special_characters', StatusCodeEnum::CONFLICT->value);
    }
}

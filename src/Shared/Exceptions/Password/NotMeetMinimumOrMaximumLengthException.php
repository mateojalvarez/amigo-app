<?php

namespace Src\Shared\Exceptions\Password;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class NotMeetMinimumOrMaximumLengthException extends BaseException
{
    public function __construct()
    {
        parent::__construct('password.not_meet_minimum_or_maximum_length', StatusCodeEnum::CONFLICT->value);
    }
}

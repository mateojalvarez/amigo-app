<?php

namespace Src\Shared\Services\Balance\Exceptions;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class AlreadyExistingBalanceException extends BaseException
{
    public function __construct()
    {
        parent::__construct(
            'balance.already_exists',
            StatusCodeEnum::CONFLICT->value
        );
    }
}

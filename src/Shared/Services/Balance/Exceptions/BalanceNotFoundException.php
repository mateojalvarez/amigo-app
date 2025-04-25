<?php

namespace Src\Shared\Services\Balance\Exceptions;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class BalanceNotFoundException extends BaseException
{
    public function __construct()
    {
        parent::__construct('balance.not_found', StatusCodeEnum::NOT_FOUND->value);
    }
}

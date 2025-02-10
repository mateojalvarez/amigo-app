<?php

namespace Src\Shared\Exceptions;

use Src\Shared\Enums\StatusCodeEnum;

class DatabaseException extends BaseException
{
    public function __construct()
    {
        parent::__construct('database_error', StatusCodeEnum::INTERNAL_SERVER_ERROR->value);
    }
}

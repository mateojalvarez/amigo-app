<?php

namespace Src\Shared\Exceptions;

use Src\Shared\Enums\StatusCodeEnum;

class BadRequestException extends BaseException
{
    public function __construct(array $errors = [])
    {
        parent::__construct(
            'wrong_fields',
            StatusCodeEnum::BAD_REQUEST->value,
            [],
            $errors
        );
    }
}

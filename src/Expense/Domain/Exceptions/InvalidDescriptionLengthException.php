<?php

namespace Src\Expense\Domain\Exceptions;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class InvalidDescriptionLengthException extends BaseException
{
    public function __construct()
    {
        parent::__construct(
            'expense.description.description_invalid_length',
            StatusCodeEnum::CONFLICT->value
        );
    }
}

<?php

namespace Src\Expense\Domain\Exceptions;

use Src\Shared\Enums\StatusCodeEnum;
use Src\Shared\Exceptions\BaseException;

class InvalidNoteLengthException extends BaseException
{
    public function __construct()
    {
        parent::__construct(
            'expense.note.note_invalid_length',
            StatusCodeEnum::CONFLICT->value
        );
    }
}

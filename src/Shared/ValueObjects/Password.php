<?php

namespace Src\Shared\ValueObjects;

use Hash;
use Src\Shared\Exceptions\Password\NotHasNumbersException;
use Src\Shared\Exceptions\Password\NotHasSpecialCharactersException;
use Src\Shared\Exceptions\Password\NotHasUpperAndLowerCaseException;
use Src\Shared\Exceptions\Password\NotMeetMinimumOrMaximumLengthException;
use Src\Shared\Helpers\StringHelper;

readonly class Password
{
    /**
     * @throws NotHasNumbersException
     * @throws NotHasSpecialCharactersException
     * @throws NotMeetMinimumOrMaximumLengthException
     * @throws NotHasUpperAndLowerCaseException
     */
    public function __construct(
        private string $value
    ) {
        $this->validate();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function hashedValue(): string
    {
        return Hash::make($this->value);
    }

    /**
     * @throws NotHasNumbersException
     * @throws NotHasSpecialCharactersException
     * @throws NotMeetMinimumOrMaximumLengthException
     * @throws NotHasUpperAndLowerCaseException
     */
    private function validate(): void
    {
        $lengthPassword = StringHelper::getLength($this->value);

        if ($lengthPassword < 8 || $lengthPassword > 40) {
            throw new NotMeetMinimumOrMaximumLengthException();
        }

        if (! StringHelper::hasUpperCase($this->value) || ! StringHelper::hasLowerCase($this->value)) {
            throw new NotHasUpperAndLowerCaseException();
        }

        if (! StringHelper::hasNumbers($this->value)) {
            throw new NotHasNumbersException();
        }

        if (! StringHelper::hasSpecialCharacter($this->value)) {
            throw new NotHasSpecialCharactersException();
        }
    }
}

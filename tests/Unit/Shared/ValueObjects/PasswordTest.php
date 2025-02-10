<?php

namespace Tests\Unit\Shared\ValueObjects;

use Src\Shared\Exceptions\Password\NotHasNumbersException;
use Src\Shared\Exceptions\Password\NotHasSpecialCharactersException;
use Src\Shared\Exceptions\Password\NotHasUpperAndLowerCaseException;
use Src\Shared\Exceptions\Password\NotMeetMinimumOrMaximumLengthException;
use Src\Shared\ValueObjects\Password;
use Tests\PreventDatabaseCalls;
use Tests\TestCase;

/**
 * @internal
 */
class PasswordTest extends TestCase
{
    use PreventDatabaseCalls;

    /**
     * @throws NotHasNumbersException
     * @throws NotMeetMinimumOrMaximumLengthException
     * @throws NotHasSpecialCharactersException
     */
    public function test_should_fail_by_not_having_upper_and_lower_case(): void
    {
        $this->expectException(NotHasUpperAndLowerCaseException::class);

        $password = 'password';
        new Password($password);
    }

    /**
     * @throws NotMeetMinimumOrMaximumLengthException
     * @throws NotHasUpperAndLowerCaseException
     * @throws NotHasSpecialCharactersException
     */
    public function test_should_fail_by_not_having_numbers(): void
    {
        $this->expectException(NotHasNumbersException::class);

        $password = 'Password';
        new Password($password);
    }

    /**
     * @throws NotHasNumbersException
     * @throws NotHasUpperAndLowerCaseException
     * @throws NotMeetMinimumOrMaximumLengthException
     */
    public function test_should_fail_by_not_having_special_characters(): void
    {
        $this->expectException(NotHasSpecialCharactersException::class);

        $password = 'Password123';
        new Password($password);
    }

    /**
     * @throws NotHasNumbersException
     * @throws NotHasSpecialCharactersException
     * @throws NotHasUpperAndLowerCaseException
     */
    public function test_should_fail_by_not_meeting_minimum_or_maximum_length(): void
    {
        $this->expectException(NotMeetMinimumOrMaximumLengthException::class);

        $password = 'P1a#';
        new Password($password);
    }
}

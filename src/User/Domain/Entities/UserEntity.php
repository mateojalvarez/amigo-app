<?php

namespace Src\User\Domain\Entities;

use Src\Shared\Exceptions\Password\NotHasNumbersException;
use Src\Shared\Exceptions\Password\NotHasSpecialCharactersException;
use Src\Shared\Exceptions\Password\NotHasUpperAndLowerCaseException;
use Src\Shared\Exceptions\Password\NotMeetMinimumOrMaximumLengthException;
use Src\Shared\ValueObjects\Email;
use Src\Shared\ValueObjects\Password;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserUuid;

class UserEntity
{
    private UserId $id;

    private UserUuid $uuid;
    private ?Password $password = null;

    /**
     * @throws NotHasNumbersException
     * @throws NotHasSpecialCharactersException
     * @throws NotMeetMinimumOrMaximumLengthException
     * @throws NotHasUpperAndLowerCaseException
     */
    public function __construct(
        private readonly string $name,
        private readonly Email $email,
        ?string $uuid = null,
        ?string $password = null
    ) {
        if (! $uuid) {
            $this->generateUuid();
        } else {
            $this->uuid = new UserUuid($uuid);
        }

        if ($password) {
            $this->password = new Password($password);
        }
    }

    public function setId(UserId $id): void
    {
        $this->id = $id;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getUuid(): UserUuid
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): ?Password
    {
        return $this->password;
    }

    private function generateUuid(): void
    {
        $this->uuid = new UserUuid(uniqid(more_entropy: true));
    }
}

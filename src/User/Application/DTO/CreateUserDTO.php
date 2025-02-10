<?php

namespace Src\User\Application\DTO;

readonly class CreateUserDTO
{
    public function __construct(
        private string $email,
        private string $name,
        private ?string $password,
        private ?string $uuid
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}

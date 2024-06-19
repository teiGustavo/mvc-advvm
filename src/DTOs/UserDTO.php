<?php

namespace Advvm\DTOs;

class UserDTO
{
    public function __construct(
        private string $email,
        private string $password,
        private int|bool $adm,
        private ?int $id = null,
    ) {
    }

    public static function create(string $email = '', string $password = '', int|bool $adm = false, ?int $id = null): self
    {
        return new self($email, $password, $adm, $id);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isAdministrator(): bool
    {
        if (is_int($this->adm)) {
            if ($this->adm === 1) {
                return true;
            }

            return false;
        }

        return $this->adm;
    }
}

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

    public function getId(): int
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
            if ($this->adm === ROLE_ADMINISTRATOR) {
                return true;
            }

            return false;
        }

        return $this->adm;
    }

    public function getRoleCode(): int
    {
        if ($this->isAdministrator()) {
            return 1;
        }

        return $this->adm;
    }

    public function getRoleName(): string
    {
        if ($this->isAdministrator()) {
            return 'Administrador';
        } else if ($this->adm === ROLE_TO_APPROVE) {
            return 'Aguardando Aprovação';
        }

        return 'Usuário';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password,
            'adm' => $this->adm,
        ];
    }
}

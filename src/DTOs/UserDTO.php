<?php

namespace Advvm\DTOs;

use Advvm\Library\Roles;

class UserDTO
{
    public function __construct(
        private string $email,
        private string $password,
        private ?int $adm,
        private ?int $id = null,
    ) {
    }

    public static function create(string $email = '', string $password = '', int $adm = null, ?int $id = null): self
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
        if (!is_null($this->adm)) {
            if ($this->adm === Roles::ADMINISTRATOR) {
                return true;
            }

            return false;
        }

        return $this->adm;
    }

    public function getRoleCode(): ?int
    {
        return $this->adm;
    }

    public function getRoleName(): string
    {
        if ($this->isAdministrator()) {
            return 'Administrador';
        } else if ($this->adm === Roles::NEEDS_APPROVAL) {
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
            'role' => $this->adm,
        ];
    }
}

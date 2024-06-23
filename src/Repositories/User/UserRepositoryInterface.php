<?php

namespace Advvm\Repositories\User;

use Advvm\Models\User;
use Advvm\DTOs\UserDTO;

interface UserRepositoryInterface
{
    public function __construct(User $model);
    public function findUserByEmail(string $email): ?UserDTO;
    public function findUserById(int $id): ?UserDTO;

    /**
     * @return array<UserDTO>
    */
    public function getAllUsers(): array;

    public function updateUserById(UserDTO $user, int $id): bool;
    public function deleteUserById(int $id): bool;
}

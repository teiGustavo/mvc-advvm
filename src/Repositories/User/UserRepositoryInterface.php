<?php

namespace Advvm\Repositories\User;

use Advvm\Models\User;
use Advvm\DTOs\UserDTO;

interface UserRepositoryInterface
{
    public function __construct(User $model);
    public function findUserByEmail(string $email): ?UserDTO;
}

<?php

namespace Advvm\Repositories\User;

use Advvm\Models\User;
use Advvm\DTOs\UserDTO;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private User $model)
    {
    }

    public function findUserByEmail(string $email): ?UserDTO
    {
        $params = http_build_query(["email" => $email]);

        [$user] = $this->model
            ->find("email = :email", $params)
            ->limit(1)
            ->fetch(true);

        if ($user) {
            return new UserDTO($user->email, $user->password, $user->adm, $user->id);
        }

        return null;
    }
}

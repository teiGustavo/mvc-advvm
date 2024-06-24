<?php

namespace Advvm\Repositories\User;

use Advvm\Models\User;
use Advvm\DTOs\UserDTO;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private User $model
    ) {
    }

    public function createNewUser(UserDTO $user): bool
    {
        $newUser = $this->model;

        $newUser->email = $user->getEmail();
        $newUser->password = password_hash($user->getPassword(), PASSWORD_BCRYPT);
        $newUser->adm = RULE_TO_APPROVE;

        return $newUser->save();
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

    public function findUserById(int $id): ?UserDTO
    {
        $user = $this->model->findById($id);

        if ($user) {
            return new UserDTO($user->email, '********', $user->adm, $user->id);
        }

        return null;
    }

    public function getAllUsers(): array
    {
        $users = $this->model
            ->find()
            ->fetch(true);

        if ($users) {
            $array = [];

            foreach ($users as $user) {
                $array[] = new UserDTO($user->email, '********', $user->adm, $user->id);
            }

            return $array;
        }

        return [];
    }

    public function updateUserById(UserDTO $user, int $id): bool
    {
        $newUser = $this->model->findById($id);

        $newUser->adm = $user->getRoleCode();

        return $newUser->save();
    }

    public function deleteUserById(int $id): bool
    {
        $user = $this->model->findById($id);

        if ($user) {
            return $user->destroy();
        }

        return false;
    }

}

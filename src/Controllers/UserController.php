<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use Advvm\Repositories\User\UserRepositoryInterface;
use Advvm\DTOs\UserDTO;
use Advvm\Library\Roles;

class UserController
{
    public function __construct(
        protected Router $router,
        private UserRepositoryInterface $repository
    ) {
    }

    public function create(array $data): void
    {
        $data = filter_var_array($data, FILTER_DEFAULT);

        if (empty($data) || in_array("", $data)) {
            $callback["message"] = "Por favor, informe todos os campos!";
            echo json_encode($callback);

            return;
        }

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $password = filter_var($data["password"]);

        $user = new UserDTO($email, $password, Roles::NEEDS_APPROVAL);

        if (!$this->repository->createNewUser($user)) {
            $callback["message"] = "Erro ao cadastrar o registro!";
            echo json_encode($callback);

            return;
        }

        $callback["message"] = "Registro cadastrado com sucesso!";

        echo json_encode($callback);
    }

    public function find(array $data): void
    {
        if (empty($data["id"])) {
            $callback["message"] = 'Por favor, informe o ID!';
            echo json_encode($callback);

            return;
        }

        $id = filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT);

        $user = $this->repository->findUserById($id);

        if ($user) {
            $callback["user"] = $user->toArray();
        } else {
            $callback["message"] = 'Usuário não encontrado!';
        }

        echo json_encode($callback);
    }

    public function findByEmail(array $data): void
    {
        if (empty($data["email"])) {
            $callback["message"] = 'Por favor, informe o email a ser pesquisado!';
            echo json_encode($callback);

            return;
        }

        $email = filter_var($data["email"], FILTER_SANITIZE_EMAIL);

        $user = $this->repository->findUserByEmail($email);

        if ($user) {
            $callback["user"] = [
                'email' => $user->getEmail()
            ];
        } else {
            $callback["message"] = 'Usuário não encontrado!';
        }

        echo json_encode($callback);
    }

    public function update(array $data): void
    {
        if (empty($data["id"])) {
            $callback["message"] = "Por favor, preencha o campo de ID!";
            echo json_encode($callback);

            return;
        }

        $id = filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT);
        $role = (int) filter_var($data['role'], FILTER_SANITIZE_NUMBER_INT);

        $newUser = UserDTO::create(adm: $role);
        $result = $this->repository->updateUserById($newUser, $id);

        if ($result === false) {
            $callback["message"] = "Erro ao salvar!";
        } else {
            $callback["user"] = [
                'id' => $id,
                'role' => $newUser->getRoleName()
            ];
        }

        echo json_encode($callback);
    }

    public function updatePassword(array $data): void
    {
        if (empty($data["password"])) {
            $callback["message"] = "Por favor, insira a nova senha!";
            echo json_encode($callback);

            return;
        }

        $email = filter_var($data["email"], FILTER_SANITIZE_EMAIL);
        $password = filter_var($data['password']);

        $user = $this->repository->findUserByEmail($email);

        if (is_null($user)) {
            $callback["message"] = "Usuário não encontrado!";
            echo json_encode($callback);

            return;
        }

        $newUser = UserDTO::create(password: $password);
        $result = $this->repository->updateUserById($newUser, $user->getId());

        if ($result === false) {
            $callback["message"] = "Erro ao salvar!";
        } else {
            $callback["user"] = [
                'email' => $email
            ];
        }

        echo json_encode($callback);
    }

    public function delete(array $data): void
    {
        if (empty($data["id"])) {
            if ($data["id"] <= 0) {
                $callback["message"] = "O ID precisa ser um número positivo!";
                echo json_encode($callback);
            }

            return;
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        if ($id <= 0) {
            $callback["message"] = "O ID precisa ser um número positivo!";
            echo json_encode($callback);

            return;
        }

        $result = $this->repository->deleteUserById($id);

        if ($result === false) {
            $callback["message"] = "Não foi possível excluir este campo!";
        }

        $callback["remove"] = $result;

        echo json_encode($callback);
    }
}

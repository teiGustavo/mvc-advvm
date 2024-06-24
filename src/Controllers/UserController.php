<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use Advvm\Repositories\User\UserRepositoryInterface;
use Advvm\DTOs\UserDTO;

class UserController
{
    protected array $data;

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

        $user = new UserDTO($email, $password, RULE_TO_APPROVE);

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
            return;
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        $user = $this->repository->findUserById($id);

        if ($user) {
            $callback["user"] = $user->toArray();
        } else {
            $callback["user"] = 'Relatório não encontrado!';
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

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);
        $role = (int) filter_var($data['role'], FILTER_VALIDATE_INT);

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

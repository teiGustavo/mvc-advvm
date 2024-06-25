<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Advvm\Repositories\User\UserRepository;
use Advvm\DTOs\UserDTO;
use Advvm\Library\JsonWebToken;
use Advvm\Library\Session;

class AuthController
{
    public function __construct(
        protected Router $router,
        private Engine $view,
        private UserRepository $repository
    ) {
        $this->view->setDirectory($this->view->getDirectory() . '/auth');
    }

    public function login(): void
    {
        $params = [
            "title" => "Entrar | " . SITE
        ];

        echo $this->view->render("login", $params);
    }

    public function logout()
    {
        Session::removeAll();

        return $this->router->redirect("auth.login");
    }

    public function register(): void
    {
        $params = [
            "title" => "Criar Conta | " . SITE
        ];

        echo $this->view->render("register", $params);
    }

    public function createUser(array $data): void
    {
        $data = filter_var_array($data, FILTER_DEFAULT);

        if (empty($data) || in_array("", $data)) {
            $this->router->redirect('auth.register');
            return;
        }

        $email = filter_var($data["email"], FILTER_SANITIZE_EMAIL);
        $password = filter_var($data["password"]);

        $user = new UserDTO($email, $password, ROLE_TO_APPROVE);

        if (!$this->repository->createNewUser($user)) {
            $this->router->redirect('auth.register');
            return;
        }

        $this->router->redirect('auth.congrats');
    }

    public function congrats(): void
    {
        $params = [
            "title" => "Parabéns | " . SITE,
        ];

        echo $this->view->render("congrats", $params);
    }

    public function wait(): void
    {
        $params = [
            "title" => "Aguarde | " . SITE,
        ];

        echo $this->view->render("wait", $params);
    }

    public function forgot(): void
    {
        $params = [
            "title" => "Esqueceu a Senha | " . SITE,
        ];

        echo $this->view->render("forgot", $params);
    }

    public function post(): void
    {
        $data = filter_input_array(INPUT_POST);
        $email = filter_var($data["email"], FILTER_SANITIZE_EMAIL);
        $password = filter_var($data["password"]);

        $user = $this->repository->findUserByEmail($email);

        if (is_null($user)) {
            $this->router->redirect("auth.login");
            return;
        }

        if ($user->getRoleCode() === ROLE_TO_APPROVE) {
            $this->router->redirect("auth.wait");
            return;
        }

        if (password_verify($password, $user->getPassword())) {
            $credentials = [
                "id" => $user->getId(),
                "email" => $user->getEmail(),
                "role" => $user->getRoleCode()
            ];

            $jwt = JsonWebToken::generate($credentials);

            Session::set('token', $jwt);

            $this->router->redirect("advvm.home");
            return;
        }

        $this->router->redirect("auth.login");
        return;
    }
}

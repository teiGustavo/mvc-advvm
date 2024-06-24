<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Advvm\Repositories\User\UserRepository;
use Advvm\DTOs\UserDTO;

class AuthController
{
    public function __construct(
        protected Router $router,
        private Engine $view,
        private UserRepository $repository
    ) {
        $this->view->setDirectory($this->view->getDirectory() . '/auth');
    }

    //Responsável por renderizar a página "Login"
    public function login(): void
    {
        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Entrar | " . SITE
        ];

        //Renderiza a página
        echo $this->view->render("login", $params);
    }

    //Responsável por deslogar o usuário
    public function logout()
    {
        //Inicializa as sessões
        initializeSessions(["token" => ""]);

        //Redireciona o usuário para a rota de home
        return $this->router->redirect("auth.login");
    }

    public function register(): void
    {
        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Criar Conta | " . SITE
        ];

        //Renderiza a página
        echo $this->view->render("register", $params);
    }

    public function createUser(array $data): void
    {
        $data = filter_var_array($data, FILTER_DEFAULT);

        if (empty($data) || in_array("", $data)) {
            $this->router->redirect('auth.register');

            return;
        }

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $password = filter_var($data["password"]);

        $user = new UserDTO($email, $password, RULE_TO_APPROVE);

        if (!$this->repository->createNewUser($user)) {
            $this->router->redirect('auth.register');

            return;
        }

        $this->router->redirect('auth.wait');
    }

    public function wait(): void
    {
        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Parabéns | " . SITE
        ];

        //Renderiza a página
        echo $this->view->render("wait", $params);
    }

    //Responsável por tratar os dados do formulário
    public function post()
    {
        //Recuperando os dados enviados via POST
        $data = filter_input_array(INPUT_POST);
        $email = $data["email"];
        $password = $data["password"];

        $user = $this->repository->findUserByEmail($email);

        //Verificando se o Usuário foi encontrado
        if ($user && password_verify($password, $user->getPassword())) {
            //Informações a serem passadas pelo Token
            $credentials = [
                "ID" => $user->getId(),
                "Email" => $user->getEmail(),
                "ADM" => $user->isAdministrator()
            ];

            //Instancia o método que retorna o token JWT
            $jwt = $this->JWT($credentials);

            //Define a sessão ou cookie do Token
            initializeSessions(["token" => $jwt, "logged" => true]);

            return $this->router->redirect("advvm.home");
        } else {
            initializeSessions(["logged" => false]);
            return $this->router->redirect("auth.login");
        }
    }

    private function JWT(array $credentials): string
    {
        $expTime = time() + (1 * 1 * 60 * 60); //(Dias * Horas * Minutos * Segundos)

        //Cabeçalho do token (Primeira parte do token JWT)
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $header = base64_encode(json_encode($header));

        //Segunda parte do token JWT (Carga útil)
        $payload = [
            'iss' => APP_URL,
            'aud' => APP_URL,
            'exp' => $expTime,
            'id' =>  $credentials["ID"],
            'email' =>  $credentials["Email"],
            'adm' =>  $credentials["ADM"]
        ];

        $payload = base64_encode(json_encode($payload));

        $signature = hash_hmac('sha256', "$header.$payload", JWT_KEY, true);
        $signature = base64_encode($signature);

        //Retorna o token JWT
        return "$header.$payload.$signature";
    }
}

<?php

namespace Advvm\Controllers;

use Advvm\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends MainController
{

    //Responsável por passar os parâmetros para o Controller pai (MainController)
    public function __construct($router)
    {
        //Instancia o construtor da classe pai
        parent::__construct($router, [], dirname(__DIR__, 2) . "/views/auth");
    }

    //Responsável por renderizar a página "Login"
    public function login(): void
    {
        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Login | " . SITE
        ];
        
        //Renderiza a página
        echo $this->view->render("login", $params);
    }

    //Responsável por deslogar o usuário
    public function logout()
    {
        //Inicializa as sessões
        initializeSessions(); 

        //Verifica se a sessão "Logged" existe, se sim, a torna como falsa
        if (isset($_SESSION["logged"])) {
            $_SESSION["logged"] = false;
        }

        //Redireciona o usuário para a rota de home
        return $this->router->redirect("advvm.home");
    }

    //Responsável por tratar os dados do formulário
    public function post()
    {
        //Recuperando os dados enviados via POST
        $data = filter_input_array(INPUT_POST);
        $email = $data["email"];
        $password = $data["password"];

        //Instanciando o model Users
        $users = new User();

        //Preparando a query SQL
        $params = http_build_query(["email" => $email]);

        //Executando a query sql e guardando os dados retornados (Active Record)
        $user = $users->find("email = :email", $params)->limit(1)->fetch(true);

        //Facilitando os usos futuros do vetor das informações do Usuário
        $user = $user[0];

        //Verificando se o Usuário foi encontrado
        if ($user && password_verify($password, $user->senha)) {
            initializeSessions(["logged" => true]);  
            return $this->router->redirect("advvm.home");
        } else {
            initializeSessions(["logged" => false]);  
            return $this->router->redirect("auth.login");
        }
    }

    private function JWT()
    {

        $key = 'ADSHWWTSX2566018GT';
        $payload = [
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            'iat' => 1356999524,
            'nbf' => 1357000000
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

        print_r($decoded);

        $decoded_array = (array) $decoded;

        JWT::$leeway = 60; // $leeway in seconds
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    }
}
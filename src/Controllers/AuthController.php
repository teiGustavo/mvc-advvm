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
        initializeSessions(["token" => ""]);

        //Redireciona o usuário para a rota de home
        return $this->router->redirect("auth.login");
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
        if ($user && password_verify($password, $user->password)) {
            //Informações a serem passadas pelo Token
            $credentials = [
                "ID" => $user->id,
                "Email" => $email, 
                "ADM" => $user->adm
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
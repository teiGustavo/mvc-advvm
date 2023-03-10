<?php

namespace Advvm\Controllers;
use Advvm\Models\User;

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
}
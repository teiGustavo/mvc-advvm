<?php

namespace Advvm\Controllers;

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
}
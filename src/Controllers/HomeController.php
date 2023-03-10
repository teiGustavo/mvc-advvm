<?php

namespace Advvm\Controllers;

use Advvm\Models\User;

class HomeController extends MainController
{

    //Responsável por passar os parâmetros para o Controller pai (MainController)
    public function __construct($router)
    {
        //Instancia o construtor da classe pai
        parent::__construct($router);
    }

    //Responsável por renderizar a página "Home" (página inicial)
    public function index()
    {
        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Início | " . SITE,
            "users" => (new User())->find()->fetch(true)
        ];   
        
        //Renderiza a página
        echo $this->view->render("home", $params);
    }
}


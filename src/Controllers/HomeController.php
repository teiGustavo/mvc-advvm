<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;

class HomeController
{
    public function __construct(
        protected Router $router,
        private Engine $view
    ) {
    }

    //Responsável por renderizar a página "Home" (página inicial)
    public function index()
    {
        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Início | " . SITE
        ];

        //Renderiza a página
        echo $this->view->render("home", $params);
    }

    //Responsável por renderizar a página de erros (view)
    public function error($data)
    {
        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Erro {$data['errcode']} | " . SITE,
            "error" => $data["errcode"]
        ];

        //Renderiza a página
        echo $this->view->render("error", $params);
    }
}

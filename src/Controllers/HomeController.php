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

    public function index()
    {
        $params = [
            "title" => "Início | " . SITE
        ];

        echo $this->view->render("home", $params);
    }

    public function error($data)
    {
        $params = [
            "title" => "Erro {$data['errcode']} | " . SITE,
            "error" => $data["errcode"]
        ];

        echo $this->view->render("error", $params);
    }
}

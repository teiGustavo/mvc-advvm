<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;

//Classe a ser estendida pelos Controllers
abstract class MainController
{
    protected $view;
    protected $router;

    //Método responsável por definir todos os valores comuns entre os Controllers (Sistema de plates do PHP)
    public function __construct($router, $globals = [], $dir = null)
    {
        //$this->templates->addFolder("login", __DIR__ . "/../../views/auth");
        
        //Define o diretório da localização das views (templates)
        $dir = $dir ?? dirname(__DIR__, 2) . "/views/";

        //Instancia o objeto das views (Plates)
        $this->view = new Engine($dir);

        //Define o roteador
        $this->router = $router;

        //Adiciona o roteador globalmente a todos os Controllers que estendam o MainController
        $this->view->addData(["router" => $this->router]);
        if ($globals)
            $this->view->addData($globals);
    }
}


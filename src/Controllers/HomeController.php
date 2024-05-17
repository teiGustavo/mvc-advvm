<?php

namespace Advvm\Controllers;

use League\Plates\Engine;

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
            "title" => "Início | " . SITE
        ];

        //Renderiza a página
        echo $this->view->render("home", $params);
    }

    //Responsável por renderizar a página de erros (view)
    public function error($data)
    {
        $templates = new Engine(__DIR__ . "/../../views");

        //Cria a base da página
        $template = $templates->make("error");
        
        //Define os valores a serem passados para o template
        $template->data([
            "title" => "Erro {$data['errcode']} | " . SITE,
            "error" => $data["errcode"]
        ]);

        //Renderiza a página ("método mágico")
        echo $template;
    }
}
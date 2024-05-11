<?php

namespace Advvm\Controllers;

use League\Plates\Engine;

class Web 
{
    private $templates;

    public function __construct()
    {
        $this->templates = new Engine(__DIR__ . "/../../views");
    }

    //Responsável por retornar um teste das rotas da "Home"
    public function home($data)
    {
       echo "<h1>Home</h1>";
       echo '<pre>';
           var_dump($data);
       echo '</pre>';
    }

    //Responsável por retornar um teste do phpinfo()
    public function phpinfo($data)
    {
        require(__DIR__ . "/../../views/examples/phpinfo.php");
    }

    //Responsável por retornar um teste do vardump()
    public function vardump($data)
    {
        require(__DIR__ . "/../../views/examples/vardump.php");
    }

    //Responsável por renderizar a página de erros (view)
    public function error($data)
    {
        //Cria a base da página
        $template = $this->templates->make("error");
        
        //Define os valores a serem passados para o template
        $template->data([
            "title" => "Erro {$data['errcode']} | " . SITE,
            "error" => $data["errcode"]
        ]);

        //Renderiza a página ("método mágico")
        echo $template;
    }

    //Teste de implementação da função Create do CRUD (examples)
    public function create($data)
    {
        require(__DIR__ . "/../../views/examples/create.php");
    }

    //Teste de implementação da função Read do CRUD (examples)
    public function read($data)
    {
        require(__DIR__ . "/../../views/examples/read.php");
    }

    //Teste de implementação da função Update do CRUD (examples)
    public function update($data)
    {
        require(__DIR__ . "/../../views/examples/update.php");
    }

    //Teste de implementação da função Delete do CRUD (examples)
    public function delete($data)
    {
        require(__DIR__ . "/../../views/examples/delete.php");
    }
}
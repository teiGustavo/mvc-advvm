<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;

class CadastrarController
{
    protected array $data;

    public function __construct(
        protected Router $router,
        private Engine $view
    ) {
        $this->view->setDirectory($this->view->getDirectory() . '/admin/cadastrar');
    }

    public function selecionarMes(): void
    {
        $params = [
            "title" => "Selecionar Mês | " . SITE
        ];

        echo $this->view->render("mes", $params);
    }

    public function mes($data): void
    {
        function getLastDayFromCurrentMonth(string $month): string
        {
            return date("t", strtotime($month));
        }

        $data = filter_var_array($data, FILTER_DEFAULT);

        if (empty($data["date"])) {
            // $callback["message"] = "Por favor, informe o mês para iniciar!";
            // echo json_encode($callback);

            echo $this->router->redirect("cadastrar.selecionarMes");

            return;
        }

        $date = explode("-", $data['date']);

        initializeSessions([
            "date" => $data["date"],
            "month" => $date[1],
            "year" => $date[0],
            "lastDay" => getLastDayFromCurrentMonth($data["date"])
        ]);

        $this->router->redirect("cadastrar.cadastro");
    }

    public function cadastro(): void
    {
        initializeSessions();

        $params = [
            "title" => "Cadastrar | " . SITE,
            "date" => $_SESSION["date"],
            "month" => $_SESSION["month"],
            "year" => $_SESSION["year"],
            "lastDay" => $_SESSION["lastDay"]
        ];

        echo $this->view->render("cadastro", $params);
    }
}

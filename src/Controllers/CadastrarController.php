<?php

namespace Advvm\Controllers;

use Advvm\Models\Report;

class CadastrarController extends MainController
{

    protected array $data;

    //Responsável por passar os parâmetros para o Controller pai (MainController)
    public function __construct($router)
    {
        //Define o roteamento do AdminController
        $this->router = $router;

        //Instancia o construtor da Classe pai
        parent::__construct($router, [], dirname(__DIR__, 2) . "/views/admin/cadastrar");
    }

    public function selecionarMes($data): void
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

    public function create($data)
    {
        $data = filter_var_array($data, FILTER_DEFAULT);

        if (in_array("", $data)) {
            $callback["message"] = "Por favor, informe todos os campos!";
            echo json_encode($callback);

            return;
        }

        //Prevenção de erros
        $data["report"] = ucfirst($data["report"]);
        $data["amount"] = formatFloatToSqlPattern($data['amount']);

        //Checando se o lançamento é uma Entrada ou Saída
        $opcoes = [
          "Oferta", "Ofertas", "Dízimo", "Dízimos", "Dizimo", "Dizimos", "Saldo Anterior"
        ];

        if (($data["type"] === "Automático") && (in_array($data["report"], $opcoes))) {
            $data["type"] = "Entrada";
        } else {
            $data["type"] = "Saída";
        }


        $report = new Report();
        $report->date = $data["date"];
        $report->report = $data["report"];
        $report->type = $data["type"];
        $report->amount = $data["amount"];

        if (APP_ENV != 'prod' && APP_ENV != 'production') {
            var_dump($data);
            var_dump($report);
        } else {
            $report->save();
            $this->router->redirect("cadastrar.cadastro");
        }
    }
}
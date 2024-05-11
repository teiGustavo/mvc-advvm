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

        if (empty($data["data_lancamento"])) {
            // $callback["message"] = "Por favor, informe o mês para iniciar!";
            // echo json_encode($callback);

            echo $this->router->redirect("cadastrar.selecionarMes");

            return;
        }

        $data_lancamento = explode("-", $data['data_lancamento']);

        initializeSessions([
            "date" => $data["data_lancamento"],
            "month" => $data_lancamento[1],
            "year" => $data_lancamento[0],
            "lastDay" => getLastDayFromCurrentMonth($data["data_lancamento"])
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
        $data["lancamento"] = ucfirst($data["lancamento"]);
        $data["valor"] = formatFloatToSqlPattern($data['valor']);

        //Checando se o lançamento é uma Entrada ou Saída
        $opcoes = [
          "Oferta", "Ofertas", "Dízimo", "Dízimos", "Dizimo", "Dizimos", "Saldo Anterior"
        ];

        if (($data["tipo"] === "Automático") && (in_array($data["lancamento"], $opcoes))) {
            $data["tipo"] = "Entrada";
        } else {
            $data["tipo"] = "Saída";
        }


        $report = new Report();
        $report->data_report = $data["data_lancamento"];
        $report->historico = $data["lancamento"];
        $report->tipo = $data["tipo"];
        $report->valor = $data["valor"];

        if (APP_ENV != 'prod' && APP_ENV != 'production') {
            var_dump($data);
            var_dump($report);
        } else {
            $report->save();
            $this->router->redirect("cadastrar.cadastro");
        }
    }
}
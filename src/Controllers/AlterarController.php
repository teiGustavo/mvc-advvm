<?php

namespace Advvm\Controllers;

use Advvm\Models\Report;

class AlterarController extends MainController
{
    protected array $data;

    public function __construct($router)
    {
        //Define o roteamento do AdminController
        $this->router = $router;

        //Instancia o construtor da Classe pai
        parent::__construct($router, [], dirname(__DIR__, 2) . "/views/admin/alterar");
    }

    public function index($data): void
    {
        $params = [
            "title" => "Alterar Lançamentos | " . SITE,
            "reports" => (new Report())->find(columns: "cod_lancamento, 
                DATE_FORMAT(data_report, '%d/%m/%Y') as data_report, historico, tipo, 
                CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(valor, 2),'.',';'),',','.'),';',',')) as valor")
                ->limit(5)
                ->fetch(true)
        ];

        echo $this->view->render("alterar", $params);
    }

    public function delete(array $data): void
    {
        if (empty($data["id"])) {
            return;
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        $report = (new Report())->findById($id);
        if ($report) {
            if ($report->destroy()) {
                $callback["remove"] = true;
            } else {
                $callback["remove"] = false;
                $callback["messages"] = "Não foi possível excluir este campo!";
            }
        }

        echo json_encode($callback);
    }

    public function find(array $data): void
    {
        if (empty($data["id"])) {
            return;
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        $report = (new Report())->findById($id);

        $callback["report"] = $report->data();

        echo json_encode($callback);
    }

    public function update(array $data): void
    {
        if (empty($data["id"])) {
            return;
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        $report = (new Report())->findById($id);
        $report->data_report = $data["data"];
        $report->historico = $data["historico"];
        $report->valor = $data["valor"];
        $report->tipo = $data["tipo"];

        if (!$report->save()) {
            $callback["message"] = "Erro ao salvar!";
        }

        $data = new \DateTimeImmutable($data["data"]);
        $report->data_report = $data->format("d/m/Y");
        $report->historico = mb_strimwidth($report->historico, 0, 20, "...");
        $report->valor = number_format($report->valor,2,",",".");;

        $callback["report"] = $report->data();

        echo json_encode($callback);
    }
}
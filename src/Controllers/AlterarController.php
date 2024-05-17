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
        parent::__construct($router, [], dirname(__DIR__, 2) . "/views/admin");
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
        $report->date = $data["date"];
        $report->report = $data["report"];
        $report->amount = $data["amount"];
        $report->type = $data["type"];

        if (!$report->save()) {
            $callback["message"] = "Erro ao salvar!";
        }

        $data = new \DateTimeImmutable($data["date"]);
        $report->date = $data->format("d/m/Y");
        $report->report = mb_strimwidth($report->report, 0, 20, "...");
        $report->amount = number_format($report->amount,2,",",".");

        $callback["report"] = $report->data();

        echo json_encode($callback);
    }
}
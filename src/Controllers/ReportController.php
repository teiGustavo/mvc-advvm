<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use Advvm\Repositories\Report\ReportRepositoryInterface;
use Advvm\DTOs\ReportDTO;

class ReportController
{
    protected array $data;

    public function __construct(
        protected Router $router,
        private ReportRepositoryInterface $repository
    ) {
    }

    public function create(array $data)
    {
        $data = filter_var_array($data, FILTER_DEFAULT);

        if (empty($data) || in_array("", $data)) {
            $callback["message"] = "Por favor, informe todos os campos!";
            echo json_encode($callback);

            return;
        }

        $report = ReportDTO::create(date: $data["date"], report: $data["report"]);
        $report->setType($data["type"]);
        $report->setAmount($data["amount"]);


        if (APP_ENV != 'prod' && APP_ENV != 'production') {
            var_dump($data);
            var_dump($report);
        } else {
            if (!$this->repository->createNewReport($report)) {
                $callback["message"] = "Erro ao cadastrar o registro!";
                echo json_encode($callback);

                return;
            }

            $callback["message"] = "Registro cadastrado com sucesso!";

            echo json_encode($callback);
        }
    }

    public function find(array $data): void
    {
        if (empty($data["id"])) {
            return;
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        $report = $this->repository->findReportById($id);

        if ($report) {
            $callback["report"] = $report->toArray();
        } else {
            $callback["report"] = 'Relatório não encontrado!';
        }

        echo json_encode($callback);
    }

    public function update(array $data): void
    {
        if (empty($data["id"])) {
            $callback["message"] = "Por favor, preencha o campo de ID!";
            echo json_encode($callback);

            return;
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        $newReport = ReportDTO::create(date: $data["date"], report: $data["report"], type: $data["type"]);
        $newReport->setAmount($data["amount"]);

        $result = $this->repository->updateReportById($newReport, $id);

        if ($result === false) {
            $callback["message"] = "Erro ao salvar!";
        } else {
            $newReport->setId($id);

            $callback["report"] = [
                'id' => $newReport->getId(),
                'date' => $newReport->getFormattedDate(),
                'report' => $newReport->getReport(),
                'type' => $newReport->getType(),
                'amount' => $newReport->getAmountInBRLFormat(),
            ];
        }

        echo json_encode($callback);
    }

    public function delete(array $data): void
    {
        if (empty($data["id"])) {
            if ($data["id"] <= 0) {
                $callback["message"] = "O ID precisa ser um número positivo!";
                echo json_encode($callback);
            }

            return;
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        if ($id <= 0) {
            $callback["message"] = "O ID precisa ser um número positivo!";
            echo json_encode($callback);

            return;
        }

        $result = $this->repository->deleteReportById($id);

        if ($result === false) {
            $callback["message"] = "Não foi possível excluir este campo!";
        }

        $callback["remove"] = $result;

        echo json_encode($callback);
    }
}

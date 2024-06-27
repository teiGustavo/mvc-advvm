<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use Advvm\Repositories\Report\ReportRepositoryInterface;
use Advvm\DTOs\ReportDTO;

class ReportController
{
    public function __construct(
        protected Router $router,
        private ReportRepositoryInterface $repository
    ) {
    }

    public function create(array $data): void
    {
        $report = ReportDTO::create(date: $data["date"], report: $data["report"]);
        $report->setType($data["type"]);
        $report->setAmount($data["amount"]);

        if (!$this->repository->createNewReport($report)) {
            $callback["message"] = "Erro ao cadastrar o registro!";

            http_response_code(500);
            echo json_encode($callback);

            return;
        }

        $callback["message"] = "Registro cadastrado com sucesso!";

        http_response_code(201);
        echo json_encode($callback);
    }

    public function find(array $data): void
    {
        $report = $this->repository->findReportById($data['id']);

        if ($report) {
            $callback["report"] = $report->toArray();
        } else {
            http_response_code(404);

            $callback["message"] = 'Lançamento não encontrado!';
        }

        echo json_encode($callback);
    }

    public function update(array $data): void
    {
        $newReport = ReportDTO::create(date: $data["date"], report: $data["report"], type: $data["type"]);
        $newReport->setAmount($data["amount"]);

        $result = $this->repository->updateReportById($newReport, $data['id']);

        if ($result === false) {
            http_response_code(500);

            $callback["message"] = "Erro ao salvar!";
        } else {
            $callback["report"] = [
                'id' => $data['id'],
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
        $result = $this->repository->deleteReportById($data['id']);

        if ($result === false) {
            http_response_code(500);

            $callback["message"] = "Não foi possível excluir este lançamento!";
            echo json_encode($callback);
            
            return;
        }

        http_response_code(204);
    }
}

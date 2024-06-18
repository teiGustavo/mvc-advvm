<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use Advvm\Repositories\ReportRepositoryInterface;
use Advvm\DTOs\ReportDTO;

class AlterarController
{
    protected array $data;

    public function __construct(
        protected Router $router,
        private ReportRepositoryInterface $repository
    ) {
    }

    public function delete(array $data): void
    {
        if (empty($data["id"])) {
            return;
        }

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        $result = $this->repository->deleteReportById($id);

        if ($result === false) {
            $callback["messages"] = "Não foi possível excluir este campo!";
        }

        $callback["remove"] = $result;

        echo json_encode($callback);
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
                'report' => $newReport->getReportWithTruncatedWidth(),
                'type' => $newReport->getType(),
                'amount' => $newReport->getAmountInBRLFormat(),
            ];
        }

        echo json_encode($callback);
    }
}

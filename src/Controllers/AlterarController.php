<?php

namespace Advvm\Controllers;

use Advvm\Models\Report;
use Advvm\DTOs\ReportDTO;
use Advvm\Repositories\ReportRepositoryInterface;
use Advvm\Repositories\ReportRepository;

class AlterarController extends MainController
{
    protected array $data;

    public function __construct(
        $router,
        private ReportRepositoryInterface $repository = new ReportRepository(new Report)
    ) {
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

<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Advvm\Repositories\Report\ReportRepositoryInterface;
use Advvm\DTOs\ReportDTO;

class PaginationController
{

    protected array $data;

    public function __construct(
        protected Router $router,
        private Engine $view,
        private ReportRepositoryInterface $repository
    ) {
        $this->view->setDirectory($this->view->getDirectory() . '/pagination');
    }

    public function index(array $data): void
    {
        if (isset($data['pagecode'])) {
            $pageCode = filter_var($data['pagecode'], FILTER_SANITIZE_NUMBER_INT);
        } else {
            $pageCode = 1;
        }

        //Renderiza a página
        echo $this->view->render("paginate", $this->paginate($pageCode));
    }

    //Método responsável por fazer a paginação da view de Relatório
    private function paginate(int $pageCode = 1, int $limit = 6): array
    {
        if ($pageCode < 0) {
            $pageCode = 1;
        }

        //Define o total de Relatórios e de páginas para a Paginação
        $totalReports = $this->repository->countAll();
        $totalPages = ceil($totalReports / $limit);

        //Define os valores para o primeiro e último Relatório
        $lastReport = (int) ($limit * $pageCode);
        $firstReport = (int) ($lastReport - $limit);

        //Verifica se há a possibilidade de avançar uma página (next)
        $nextPage = ($pageCode + 1);
        if ($nextPage > $totalPages)
            $nextPage = $pageCode;

        //Verifica se há a possibilidade de retroceder uma página (previous)
        $previousPage = ($pageCode - 1);
        if ($previousPage < 1)
            $previousPage = $pageCode;

        //Instancia o objeto de Relatórios com os limites da paginação
        $reports = $this->repository->getAllReports($limit, $firstReport);

        //Retorna o array de parâmetros
        return [
            "title" => "Lançamentos | " . SITE,
            "reports" => $reports,
            "pages" => range(1, $totalPages),
            "currentPage" => $pageCode,
            "previousPage" => $previousPage,
            "nextPage" => $nextPage,
            "lastPage" => $totalPages
        ];
    }

    // public function pagination(array $data): void
    // {
    //     // var_dump($data);

    //     if (isset($data['pagecode'])) {
    //         $pageCode = filter_var($data['pagecode'], FILTER_SANITIZE_NUMBER_INT);
    //     } else {
    //         $pageCode = 1;
    //     }

    //     $limit = 6;

    //     $totalReports = $this->repository->countAll();
    //     $totalPages = ceil($totalReports / $limit);

    //     $lastReport = (int) ($limit * $pageCode);
    //     $firstReportOfAtualPage = (int) ($lastReport - $limit);

    //     $unformattedReports = $this->repository->getAllReports($limit, $firstReportOfAtualPage);

    //     $reports = [];
    //     foreach ($unformattedReports as $report) {
    //         $reports[] = [
    //             'id' => $report->getId(),
    //             'date' => $report->getFormattedDate(),
    //             'report' => $report->getReport(),
    //             'type' => $report->getType(),
    //             'amount' => $report->getAmountInBRLFormat(),
    //         ];
    //     }

    //     //Verifica se há a possibilidade de retroceder uma página (previous)
    //     $previousPage = ($pageCode - 1);
    //     if ($previousPage < 1)
    //         $previousPage = $pageCode;

    //     //Verifica se há a possibilidade de avançar uma página (next)
    //     $nextPage = ($pageCode + 1);
    //     if ($nextPage > $totalPages)
    //         $nextPage = $pageCode;

    //     $callback['reports'] = $reports;

    //     $callback['pages'] = range(1, $totalPages);

    //     $callback['currentPage'] = $pageCode;
    //     $callback['previousPage'] = $previousPage;
    //     $callback['nextPage'] = $nextPage;

    //     echo json_encode($callback);
    // }
}

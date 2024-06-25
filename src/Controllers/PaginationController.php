<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Advvm\Repositories\Report\ReportRepositoryInterface;

class PaginationController
{
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

        $pagination = $this->paginate($pageCode);
        ['lastPage' => $lastPage] = $pagination;

        if ($pageCode > $lastPage) {
            $this->router->redirect($this->router->route('pagination.page', ['pagecode' => $lastPage]));
            return;
        }

        echo $this->view->render("paginate", $pagination);
    }

    private function paginate(int $pageCode = 1, int $limit = 6): array
    {
        if ($pageCode < 0) {
            $pageCode = 1;
        }

        $totalReports = $this->repository->countAll();
        $totalPages = ceil($totalReports / $limit);

        $lastReport = (int) ($limit * $pageCode);
        $firstReport = (int) ($lastReport - $limit);

        $nextPage = ($pageCode + 1);
        if ($nextPage > $totalPages)
            $nextPage = $pageCode;

        $previousPage = ($pageCode - 1);
        if ($previousPage < 1)
            $previousPage = $pageCode;

        $reports = $this->repository->getAllReports($limit, $firstReport);

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
}

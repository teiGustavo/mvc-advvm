<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Advvm\Repositories\Report\ReportRepositoryInterface;
use Advvm\Library\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class SpreadsheetController
{
    public function __construct(
        private Router $router,
        private Engine $view,
        private ReportRepositoryInterface $repository,
    ) {
        $this->view->setDirectory($this->view->getDirectory() . '/spreadsheet');
    }

    public function index(): void
    {
        $years = $this->repository->getAllYearsOfReports();

        $params = [
            'title' => "Excel | " . SITE,
            'years' => $years
        ];

        echo $this->view->render('download', $params);
    }

    public function findMonthsOfYear(array $data): void
    {
        $year = filter_var($data['year'], FILTER_SANITIZE_NUMBER_INT);

        if (empty($data['year'])) {
            $callback['message'] = 'Por favor, selecione o ano desejado!';
            echo json_encode($callback);

            return;
        }

        $months = $this->repository->getFullNameOfMonthsOfReportsByYear($year);

        $setFirstLetterUppercase = function (string $value) {
            return ucfirst($value);
        };

        $callback['months'] = array_map($setFirstLetterUppercase, $months);

        echo json_encode($callback);
    }

    public function download(array $data): void
    {
        if (empty($data) || in_array('', $data)) {
            $callback['message'] = 'Por favor, selecione o mês desejado!';
            echo json_encode($callback);

            return;
        }

        $year = filter_var($data['year'], FILTER_SANITIZE_NUMBER_INT);
        $month = filter_var($data['month'], FILTER_SANITIZE_ENCODED, FILTER_FLAG_STRIP_HIGH);

        $filename = NAME_TEMPLATE . ucfirst($month) . ' de ' . $year;

        $pathToDownload = (new Excel(
            new Spreadsheet,
            $this->repository->getAllReportsByYearAndMonthFullName($year, $month)
        ))->saveXlsx($filename);

        $callback['download_url'] = url($pathToDownload);

        echo json_encode($callback);
    }
}

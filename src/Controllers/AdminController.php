<?php

namespace Advvm\Controllers;

use Advvm\Library\Excel;
use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Advvm\Repositories\Report\ReportRepositoryInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet; 

class AdminController
{

    protected array $data;

    public function __construct(
        protected Router $router,
        private Engine $view,
        private ReportRepositoryInterface $repository
    ) {
        $this->view->setDirectory($this->view->getDirectory() . '/admin');
    }

    //Responsável por renderizar a página "Relatório" (view)
    public function relatorio(array $data): void
    {
        //Instancia a Paginação e define o conjunto de dados passados via GET pelo router
        $this->data = $data;
        $params = $this->pagination();

        //Renderiza a página
        echo $this->view->render("relatorio", $params);
    }

    //Responsável por renderizar a página "Excel" (view)
    public function excel(): void
    {
        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Excel | " . SITE,
            "years" => $this->repository->getAllYearsOfReports()
        ];

        //Renderiza a página
        echo $this->view->render("excel", $params);
    }

    //Responsável por renderizar a página "Spreadsheet" (view) sendo chamada pela rota POST
    public function spreadsheet(array $data): void
    {
        $data = filter_var_array($data, FILTER_DEFAULT);
        $year = $data["selectYear"];

        initializeSessions(["year" => $year]);

        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Excel | " . SITE,
            "months" => $this->repository->getFullNameOfMonthsOfReportsByYear($year)
        ];

        //Renderiza a página
        echo $this->view->render("spreadsheet", $params);
    }

    //Responsável por renderizar baixar a planilha
    public function download(array $data): void
    {
        initializeSessions();

        $data = filter_var_array($data, FILTER_DEFAULT);
    
        $year = $_SESSION["year"];
        $month = $data["selectMonth"];

        $filename = NAME_TEMPLATE . ucfirst($month) . ' de ' . $year;

        $pathToDownload = (new Excel(
            new Spreadsheet,
            $this->repository->getAllReportsByYearAndMonthFullName($year, $month)
        ))->saveXlsx($filename);

        $this->router->redirect($pathToDownload);
    }

    //Método responsável por fazer a paginação da view de Relatório
    private function pagination(): array
    {
        //Define o limite da paginação
        $limit = 6;

        //Define o total de Relatórios e de páginas para a Paginação
        $total_reports = $this->repository->countAll();
        $total_pages = ceil($total_reports / $limit);

        //Define a url base da requisição
        $url_page = "/admin/reports/page/";

        //Verifica se houve requisição da página via GET
        $current_page = 1;
        if (isset($this->data["pagecode"]))
            $current_page = $this->data["pagecode"];

        //Define os valores para o primeiro e último Relatório
        $last_report = (int) ($limit * $current_page);
        $first_report = (int) ($last_report - $limit);

        //Verifica se há a possibilidade de avançar uma página (next)
        $next_page = ($current_page + 1);
        if ($next_page > $total_pages)
            $next_page = $current_page;

        //Verifica se há a possibilidade de retroceder uma página (previous)
        $previous_page = ($current_page - 1);
        if ($previous_page < 1)
            $previous_page = $current_page;

        //Instancia o objeto de Relatórios com os limites da paginação
        $reports = $this->repository->getAllReports($limit, $first_report);

        //Define os parâmetros a serem passados para o modelo
        $params = [
            "title" => "Lançamentos | " . SITE,
            "reports" => $reports,
            "total_reports" => $total_reports,
            "total_pages" => $total_pages,
            "url_page" => $url_page,
            "current_page" => $current_page,
            "first_report" => $first_report,
            "last_report" => $last_report,
            "next_page" => $next_page,
            "previous_page" => $previous_page
        ];

        //Retorna o array de parâmetros
        return $params;
    }
}

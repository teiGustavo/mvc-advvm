<?php

namespace Advvm\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Advvm\Repositories\ReportRepositoryInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet; //Classe responsável pela manipulação da Planilha
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; //Classe que salvará a Planilha em .xlsx 
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
    public function relatorio($data): void
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
    public function spreadsheet(): void
    {
        $year = $_POST["selectYear"];
        initializeSessions(["year" => $year]);

        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Excel | " . SITE,
            "months" => $this->repository->getFullNameOfMonthsOfReportsByYear($year)
        ];

        //Renderiza a página
        echo $this->view->render("spreadsheet", $params);
    }

    //Responsável por renderizar a página "Spreadsheet" (view) sendo chamada pela rota POST
    public function download(): void
    {
        initializeSessions();

        $year = $_SESSION["year"];
        $month = $_POST["selectMonth"];

        $this->generateExcel($year, $month);

        $this->router->redirect("/files/" . $_SESSION["spreadsheet"]);
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

    //Método responsável por gerar a planilha

    private function generateExcel(string $year, string $month): void
    {
        //Instancia um novo objeto de Planilha
        $spreadsheet = new Spreadsheet();

        //Define $sheet como a Planilha ativa
        $sheet = $spreadsheet->getActiveSheet();

        //Definindo o título da planilha (conteúdo da célula A1)
        $sheet->setCellValue('A1', 'Relatório AD. Videira Verdadeira');

        //Cabeçalho da planilha
        $sheet->setCellValue('A2', 'DATA');
        $sheet->setCellValue('B2', 'HISTÓRICO');
        $sheet->setCellValue('C2', 'TIPO');
        $sheet->setCellValue('D2', 'VALOR');


        //Definindo o mês selecionado (mês atual) e o ano selecionado (ano atual)
        $current_month = $month;
        $current_year = $year;

        $reports = $this->repository->getAllReportsByYearAndMonthFullName($year, $current_month);
        $num_reports = count($reports);

        if (!($reports))
            return;

        //Definindo a matriz que será usada para preencher a Planilha
        foreach ($reports as $key => $report) {
            $texto[$key][0] = $report->getId();
            $texto[$key][1] = $report->getFormattedDate();
            $texto[$key][2] = $report->getReport();
            $texto[$key][3] = $report->getType();
            $texto[$key][4] = $report->getAmount();
        }

        //Preenchendo as células da Planilha
        $num = 0;
        for ($i = 3; $i < $num_reports + 3; $i++) {
            for ($p = 1; $p <= 4; $p++) {
                $sheet->setCellValue('A' . $i, $texto[$num][1]);
                $sheet->setCellValue('B' . $i, $texto[$num][2]);
                $sheet->setCellValue('C' . $i, $texto[$num][3]);
                $sheet->setCellValue('D' . $i, $texto[$num][4]);
            }

            $num++;
        }

        //Preenchendo as células da Planilha de resumo
        $sheet->setCellValue('A' . $num_reports + 5, 'Saldo Anterior');
        $sheet->setCellValue('A' . $num_reports + 6, 'Entradas');
        $sheet->setCellValue('A' . $num_reports + 7, 'Saídas');
        $sheet->setCellValue('A' . $num_reports + 8, 'Saldo atual');

        //Preenchendo as células da coluna do Saldo Anterior
        $sheet->setCellValue(
            'B' . $num_reports + 5,
            '=VLOOKUP("Saldo Anterior", B:D, 3, 0)'
        );

        //Preenchendo as células da Coluna de Entradas
        $sheet->setCellValue(
            'B' . $num_reports + 6,
            '=(SUMIF(C:C, "=Entrada", D:D) -B' . $num_reports + 5 . ')'
        );

        //Preenchendo as células da Coluna de Saídas
        $sheet->setCellValue(
            'B' . $num_reports + 7,
            '=SUMIF(C:C, "<>Entrada", D:D)'
        );

        //Preenchendo as células da Coluna de Saldo Atual
        $sheet->setCellValue(
            'B' . ($num_reports + 8),
            "=SUM(B" . ($num_reports + 5) . ",B" . ($num_reports + 6) . ",-B" . ($num_reports + 7) . ")"
        );

        //Definindo um vetor de estilo das bordas da Planilha
        $styleArray = [
            'Borda Externa' => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],

            'Borda Direita' => [
                'borders' => [
                    'right' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],

            'Borda Inferior' => [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];

        //Aplicando as bordas usando o vetor de estilo
        $sheet->getStyle('A1:D' . $num_reports + 2)->applyFromArray($styleArray['Borda Externa']);

        $sheet->getStyle('A2:A' . $num_reports + 2)->applyFromArray($styleArray['Borda Direita']);
        $sheet->getStyle('B2:B' . $num_reports + 2)->applyFromArray($styleArray['Borda Direita']);
        $sheet->getStyle('C2:C' . $num_reports + 2)->applyFromArray($styleArray['Borda Direita']);
        $sheet->getStyle('D2:D' . $num_reports + 2)->applyFromArray($styleArray['Borda Direita']);

        $sheet->getStyle('A1:D1')->applyFromArray($styleArray['Borda Inferior']);
        $sheet->getStyle('A2:D2')->applyFromArray($styleArray['Borda Inferior']);

        $sheet->getStyle('A' . ($num_reports + 5) . ':B' . ($num_reports + 8))
            ->applyFromArray($styleArray['Borda Externa']);
        $sheet->getStyle('A' . ($num_reports + 5) . ':A' . ($num_reports + 8))
            ->applyFromArray($styleArray['Borda Direita']);
        $sheet->getStyle('A' . ($num_reports + 5) . ':B' . ($num_reports + 5))
            ->applyFromArray($styleArray['Borda Inferior']);
        $sheet->getStyle('A' . ($num_reports + 6) . ':B' . ($num_reports + 6))
            ->applyFromArray($styleArray['Borda Inferior']);
        $sheet->getStyle('A' . ($num_reports + 7) . ':B' . ($num_reports + 7))
            ->applyFromArray($styleArray['Borda Inferior']);

        //Juntando as células para formar o título
        $sheet->mergeCells('A1:D1');

        //Alinhando o título ao centro
        $sheet->getStyle('A:D')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:D')->getAlignment()->setVertical('center');

        //Background do Título (Célula Merged A1:D1)
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('63cbce');

        //Definindo as larguras das colunas da Planilha
        $sheet->getColumnDimension('A')->setWidth('15');
        $sheet->getColumnDimension('B')->setWidth('45');
        $sheet->getColumnDimension('D')->setWidth('20');

        //Definindo as alturas das linhas da Planilha
        $sheet->getRowDimension('1')->setRowHeight('30');
        $sheet->getRowDimension('2')->setRowHeight('25');

        //Estilo da Tabela Resumo
        $sheet->getStyle('A' . ($num_reports + 5) . ':B' . ($num_reports + 8))->getFill()
            ->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A' . ($num_reports + 5) . ':B' . ($num_reports + 5))->getFill()
            ->getStartColor()->setARGB('ffffa6');
        $sheet->getStyle('A' . ($num_reports + 6) . ':B' . ($num_reports + 6))->getFill()
            ->getStartColor()->setARGB('81d41a');
        $sheet->getStyle('A' . ($num_reports + 7) . ':B' . ($num_reports + 7))->getFill()
            ->getStartColor()->setARGB('ff3838');
        $sheet->getStyle('A' . ($num_reports + 8) . ':B' . ($num_reports + 8))->getFill()
            ->getStartColor()->setARGB('b4c7dc');

        //Define os padrões de estilo dos números para toda a coluna D (correspondente ao amount) da Planilha
        $sheet->getStyle('D:D')->getNumberFormat()->setFormatCode('R$ #,##0.00');

        //Define os padrões de estilo dos números para cada linha da Tabela Resumo
        $sheet->getStyle('B' . $num_reports + 5)->getNumberFormat()
            ->setFormatCode('R$ #,##0.00');
        $sheet->getStyle('B' . $num_reports + 6)->getNumberFormat()
            ->setFormatCode('R$ #,##0.00');
        $sheet->getStyle('B' . $num_reports + 7)->getNumberFormat()
            ->setFormatCode('R$ #,##0.00');
        $sheet->getStyle('B' . $num_reports + 8)->getNumberFormat()
            ->setFormatCode('R$ #,##0.00');


        //Escapa os erros
        $sheet->getCell('B' . $num_reports + 5)->getStyle()->setQuotePrefix(true);
        $sheet->getCell('B' . $num_reports + 6)->getStyle()->setQuotePrefix(true);
        $sheet->getCell('B' . $num_reports + 7)->getStyle()->setQuotePrefix(true);
        $sheet->getCell('B' . $num_reports + 8)->getStyle()->setQuotePrefix(true);

        //Define o tamanho das linhas da Planilha
        for ($i = 3; $i <= $num_reports + 2; $i++) {
            $sheet->getRowDimension($i)->setRowHeight('20');
        }

        //Define o tamanho das linhas da Tabela Resumo
        for ($i = $num_reports + 5; $i <= $num_reports + 8; $i++) {
            $sheet->getRowDimension($i)->setRowHeight('20');
        }

        //Instancia a Planilha
        $writer = new Xlsx($spreadsheet);

        //Gera o arquivo
        $current_month = ucfirst($current_month);
        $file =  NAME_TEMPLATE . $current_month . ' de ' . $current_year . '.xlsx';
        $caminho = __DIR__ . '/../../files/' . $file;
        $writer->save($caminho);

        initializeSessions(["spreadsheet" => $file]);
    }
}

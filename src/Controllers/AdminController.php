<?php

namespace Advvm\Controllers;

use Advvm\Models\Report;
use PhpOffice\PhpSpreadsheet\Spreadsheet; //Classe responsável pela manipulação da Planilha
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; //Classe que salvará a Planilha em .xlsx 

class AdminController extends MainController
{

    protected $data;
    private $year;
    private $month;

    //Responsável por passar os parâmetros para o Controller pai (MainController)
    public function __construct($router)
    {
        //Define o roteamento do AdminController
        $this->router = $router;

        //Instancia o construtor da Classe pai
        parent::__construct($router, [], dirname(__DIR__, 2) . "/views/admin");
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
    public function excel($data): void
    {
        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Excel | " . SITE,
            "reports" => (new Report())->find("", "", "DISTINCT YEAR(data_report) as date_report")->order("YEAR(data_report) DESC")->fetch(true)
        ];

        //Renderiza a página
        echo $this->view->render("excel", $params);
    }

    //Responsável por renderizar a página "Spreadsheet" (view) sendo chamada pela rota POST
    public function spreadsheet()
    {
        $year = $_POST["selectYear"];
        initializeSessions(["year" => $year]);

        $paramsQuery = http_build_query(["year" => $year]);

        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Excel | " . SITE,
            "reports" => (new Report())->find("YEAR(data_report) = :year", $paramsQuery, "DISTINCT DATE_FORMAT(data_report, '%M') as date_report")->order("DATE_FORMAT(data_report, '%m')")->fetch(true)
        ];

        //Renderiza a página
        echo $this->view->render("spreadsheet", $params);
    }

    //Responsável por renderizar a página "Spreadsheet" (view) sendo chamada pela rota POST
    public function download()
    {
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
        $total_reports = (new Report())->find()->count();
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

        //Verifica se há a posibilidade de avançar uma página (next)
        $next_page = ($current_page + 1);
        if ($next_page > $total_pages)
            $next_page = $current_page;

        //Verifica se há a posibilidade de retroceder uma página (previous)
        $previous_page = ($current_page - 1);
        if ($previous_page < 1)
            $previous_page = $current_page;

        //Instancia o objeto de Relatórios com os limites da paginação
        $reports = (new Report())->find(
            "",
            "",
            "cod_lancamento, DATE_FORMAT(data_report, '%d/%m/%Y') as data_report, historico, tipo, CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(valor, 2),'.',';'),',','.'),';',',')) as valor"
        )->limitPagination($first_report, $limit)->fetch(true);

        //Define os parâmetros a serem passados para o template
        $params = [
            "title" => "Relatorios | " . SITE,
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

    private function generateExcel(string $year, string $month)
    {
        //Verificando se a requisição do mês ou do ano foi feita, caso contrário, trava a aplicação
        /* if (!isset($_SESSION["month"]) || !isset($_SESSION["year"])) 
            return; */
        //Instancia uma novo objeto de Planilha
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
            
        //Definindo o objeto dos relatórios e sua quantidade de linhas
        $params = http_build_query([
            "year" => "$current_year",
            "month" => "$current_month"
        ]);
        
        $reports = (new Report())->find("YEAR(data_report) = :year AND DATE_FORMAT(data_report, '%M') = :month", $params, "cod_lancamento, DATE_FORMAT(data_report, '%d/%m/%Y') as data_report, historico, tipo, valor")->order("data_report")->fetch(true);
        $num_reports = (new Report())->find("YEAR(data_report) = :year AND DATE_FORMAT(data_report, '%M') = :month", $params)->count();

        if (!($reports)) 
            return;

        //Definindo a matriz que será usada para preencher a Planilha
        foreach ($reports as $key => $report) {
            $texto[$key][0] = $report->cod_lancamento;
            $texto[$key][1] = $report->data_report;
            $texto[$key][2] = $report->historico;
            $texto[$key][3] = $report->tipo;
            $texto[$key][4] = $report->valor;
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

        //Preechendo as células da coluna do Saldo Anterior
        $sheet->setCellValue(
            'B' . $num_reports + 5,
            '=SUMIF(B3, "=Saldo Anterior", D3)'
        );

        //Preechendo as células da Coluna de Entradas
        $sheet->setCellValue(
            'B' . $num_reports + 6,
            '=(SUMIF(C:C, "=Entrada", D:D) -B' . $num_reports + 5 . ')'
        );

        //Preechendo as células da Coluna de Saídas
        $sheet->setCellValue(
            'B' . $num_reports + 7,
            '=SUMIF(C:C, "<>Entrada", D:D)'
        );

        //Preechendo as células da Coluna de Saldo Atual
        $sheet->setCellValue(
            'B' . ($num_reports + 8),
            "=SUM(B" . ($num_reports + 5) . ",B" . ($num_reports + 6) . ",-B" . ($num_reports + 7) . ")"
        );

        //Definindo um vetor de estilo das bordas da Planilha
        $styleArray = [
            'Borda Externa' => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],

            'Borda Direita' => [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],

            'Borda Inferior' => [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
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

        $sheet->getStyle('A' . ($num_reports + 5) . ':B' . ($num_reports + 8))->applyFromArray($styleArray['Borda Externa']);
        $sheet->getStyle('A' . ($num_reports + 5) . ':A' . ($num_reports + 8))->applyFromArray($styleArray['Borda Direita']);
        $sheet->getStyle('A' . ($num_reports + 5) . ':B' . ($num_reports + 5))->applyFromArray($styleArray['Borda Inferior']);
        $sheet->getStyle('A' . ($num_reports + 6) . ':B' . ($num_reports + 6))->applyFromArray($styleArray['Borda Inferior']);
        $sheet->getStyle('A' . ($num_reports + 7) . ':B' . ($num_reports + 7))->applyFromArray($styleArray['Borda Inferior']);

        //Juntando as células para formar o título
        $sheet->mergeCells('A1:D1');

        //Alinhando o título ao centro
        $sheet->getStyle('A:D')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:D')->getAlignment()->setVertical('center');
        
        //Backgroynd do Título (Célula Merged A1:D1)
        $sheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('63cbce');

        //Definindo as larguras das colunas da Planilha
        $sheet->getColumnDimension('A')->setWidth('15');
        $sheet->getColumnDimension('B')->setWidth('45');
        $sheet->getColumnDimension('D')->setWidth('20');

        //Definindo as alturas das linhas da Planilha
        $sheet->getRowDimension('1')->setRowHeight('30');
        $sheet->getRowDimension('2')->setRowHeight('25');

        //Estilo da Tabela Resumo
        $sheet->getStyle('A' . ($num_reports + 5) . ':B' . ($num_reports + 8))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A' . ($num_reports + 5) . ':B' . ($num_reports + 5))->getFill()->getStartColor()->setARGB('ffffa6');
        $sheet->getStyle('A' . ($num_reports + 6) . ':B' . ($num_reports + 6))->getFill()->getStartColor()->setARGB('81d41a');
        $sheet->getStyle('A' . ($num_reports + 7) . ':B' . ($num_reports + 7))->getFill()->getStartColor()->setARGB('ff3838');
        $sheet->getStyle('A' . ($num_reports + 8) . ':B' . ($num_reports + 8))->getFill()->getStartColor()->setARGB('b4c7dc');

        //Define os padrões de estilo dos números para toda a coluna D (correspondente ao valor) da Planilha
        $sheet->getStyle('D:D')->getNumberFormat()->setFormatCode('R$ #,##0.00');

        //Define os padrões de estilo dos números para cada linha da Tabela Resumo
        $sheet->getStyle('B' . $num_reports + 5)->getNumberFormat()->setFormatCode('R$ #,##0.00');
        $sheet->getStyle('B' . $num_reports + 6)->getNumberFormat()->setFormatCode('R$ #,##0.00');
        $sheet->getStyle('B' . $num_reports + 7)->getNumberFormat()->setFormatCode('R$ #,##0.00');
        $sheet->getStyle('B' . $num_reports + 8)->getNumberFormat()->setFormatCode('R$ #,##0.00');

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
        $file =  URL_BASE_EXCEL . $current_month . ' de ' . $current_year . '.xlsx';
        $caminho = 'files/' . $file;
        $writer->save($caminho);

        initializeSessions(["spreadsheet" => $file]);
    }

}
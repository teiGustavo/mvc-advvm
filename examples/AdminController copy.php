<?php

namespace Advvm\Controllers;

use Advvm\Models\Report;
use PhpOffice\PhpSpreadsheet\Spreadsheet; //classe responsável pela manipulação da planilha
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; //classe que salvará a planilha em .xlsx 

class AdminController extends MainController
{

    protected $data;
    protected $columns = "cod_lancamento, DATE_FORMAT(data_report, '%d/%m/%Y') as data_report, historico, tipo, CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(valor, 2),'.',';'),',','.'),';',',')) as valor";

    public function __construct($router)
    {
        $this->router = $router;
        parent::__construct($router, [], dirname(__DIR__, 2) . "/views/admin");
    }

    public function relatorio($data): void
    {
        $this->data = $data;
        $params = $this->pagination();

        echo $this->view->render("relatorio", $params);
    }

    public function excel($data): void
    {
        $this->data = $data;
        $this->generateExcel();

        $params = [
            "title" => "Excel | " . SITE
        ];

        echo $this->view->render("excel", $params);
    }

    private function pagination(): array
    {
        $limit = 6;
        $total_reports = (new Report())->find()->count();
        $total_pages = ceil($total_reports / $limit);
        $url_page = "/admin/reports/page/";

        $current_page = 1;
        if (isset($this->data["pagecode"]))
            $current_page = $this->data["pagecode"];

        $last_report = (int) ($limit * $current_page);
        $first_report = (int) ($last_report - $limit);

        $next_page = ($current_page + 1);
        if ($next_page > $total_pages)
            $next_page = $current_page;

        $previous_page = ($current_page - 1);
        if ($previous_page < 1)
            $previous_page = $current_page;

        $reports = (new Report())->find(
            "",
            "",
            "cod_lancamento, DATE_FORMAT(data_report, '%d/%m/%Y') as data_report, historico, tipo, CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(valor, 2),'.',';'),',','.'),';',',')) as valor"
        )->limitPagination($first_report, $limit)->fetch(true);

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

        return $params;
    }

    private function generateExcel()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        //Conteudo da célula A1
        $sheet->setCellValue('A1', 'Relatório AD. Videira Verdadeira');

        //Juntando as células para formar o título
        $sheet->mergeCells('A1:D1');
        $sheet->getRowDimension('1')->setRowHeight('30');

        //Alinhando o título ao centro
        $sheet->getStyle('A:D')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:D')->getAlignment()->setVertical('center');

        //Definindo larguras
        $sheet->getColumnDimension('A')->setWidth('15');
        $sheet->getColumnDimension('B')->setWidth('45');
        $sheet->getColumnDimension('D')->setWidth('20');

        //Cabeçalho da planilha
        $sheet->setCellValue('A2', 'DATA');
        $sheet->setCellValue('B2', 'HISTÓRICO');
        $sheet->setCellValue('C2', 'TIPO');
        $sheet->setCellValue('D2', 'VALOR');
        $sheet->getRowDimension('2')->setRowHeight('25');

        //Valores da planilha
        $current_month = 1;
        if (isset($this->data["month"]))
            $current_month = $this->data["month"];

        $current_year = 1;
        if (isset($this->data["year"]))
            $current_year = $this->data["year"];
            
        $params = http_build_query([
            "year" => "$current_year",
            "month" => "$current_month"
        ]);
        
        $reports = (new Report())->find("YEAR(data_report) = :year AND MONTH(data_report) = :month", $params, "cod_lancamento, DATE_FORMAT(data_report, '%d/%m/%Y') as data_report, historico, tipo, valor")->order("data_report")->fetch(true);

        $num_reports = (new Report())->find("YEAR(data_report) = :year AND MONTH(data_report) = :month", $params)->count();

        foreach ($reports as $key => $report) {
            $texto[$key][0] = $report->cod_lancamento;
            $texto[$key][1] = $report->data_report;
            $texto[$key][2] = $report->historico;
            $texto[$key][3] = $report->tipo;
            $texto[$key][4] = $report->valor;
        }

        $num = 0;
        for ($i = 3; $i < $num_reports + 3; $i++) {
            for ($p = 1; $p <= 4; $p++) {
                $sheet->setCellValue('A' . $i, $texto[$num][1]);
                $sheet->setCellValue('B' . $i, $texto[$num][2]);
                $sheet->setCellValue('C' . $i, $texto[$num][3]);
                $sheet->setCellValue('D' . $i, $texto[$num][4]);
                $sheet->getStyle('D' . $i)->getNumberFormat()->setFormatCode('R$ #,##0.00');
            }

            $num++;
        }

        for ($i = 3; $i <= $num_reports + 2; $i++) {
            $sheet->getRowDimension($i)->setRowHeight('20');
        }

        //Tabela de resumo
        $sheet->setCellValue('A' . $num_reports + 5, 'Saldo Anterior');
        $sheet->setCellValue('A' . $num_reports + 6, 'Entradas');
        $sheet->setCellValue('A' . $num_reports + 7, 'Saídas');
        $sheet->setCellValue('A' . $num_reports + 8, 'Saldo atual');

        //Coluna: Saldo Anterior
        $params = http_build_query([
            "year" => "$current_year",
            "month" => "$current_month",
            "historico" => "Saldo Anterior",
            "historicoTwo" => "S.A"
        ]);

        $report = (new Report())->find(
            "YEAR(data_report) = :year AND MONTH(data_report) = :month AND (historico = :historico OR historico = :historicoTwo)", 
            $params,
            "valor"
        )->fetch(true);

        $sheet->setCellValue('B' . $num_reports + 5, $report[0]->valor);
        $sheet->getStyle('B' . $num_reports + 5)->getNumberFormat()->setFormatCode('R$ #,##0.00');


        //Coluna: Entradas
        $params = http_build_query([
            "year" => "$current_year",
            "month" => "$current_month",
            "historico" => "Saldo Anterior",
            "historicoTwo" => "S.A",
            "type" => "Entrada"
        ]);

        $report = (new Report())->find(
            "YEAR(data_report) = :year AND MONTH(data_report) = :month AND tipo = :type AND NOT (historico = :historico OR historico = :historicoTwo)", 
            $params,
            "SUM(valor) as valor"
        )->fetch(true);

        $sheet->setCellValue('B' . $num_reports + 6, $report[0]->valor);
        $sheet->getStyle('B' . $num_reports + 6)->getNumberFormat()->setFormatCode('R$ #,##0.00');

        //Coluna: Saídas
        $params = http_build_query([
            "year" => "$current_year",
            "month" => "$current_month",
            "historico" => "Saldo Anterior",
            "historicoTwo" => "S.A",
            "type" => "Saída"
        ]);

        $report = (new Report())->find(
            "YEAR(data_report) = :year AND MONTH(data_report) = :month AND tipo = :type AND NOT (historico = :historico OR historico = :historicoTwo)", 
            $params,
            "SUM(valor) as valor"
        )->fetch(true);

        $sheet->setCellValue('B' . $num_reports + 7, $report[0]->valor);
        $sheet->getStyle('B' . $num_reports + 7)->getNumberFormat()->setFormatCode('R$ #,##0.00');

        //Coluna: Saldo
        //Set cell A4 with a formula
        $sheet->setCellValue(
            'B' . ($num_reports + 8),
            '=SUM(B50, B51, -B52)'
        );

        $sheet->getCell('B' . $num_reports + 8)->getStyle()->setQuotePrefix(true);
        $sheet->getStyle('B' . $num_reports + 8)->getNumberFormat()->setFormatCode('R$ #,##0.00');


        /*
        $params = http_build_query([
            "year" => "$current_year",
            "month" => "$current_month",
            "historico" => "Saldo Anterior",
            "historicoTwo" => "S.A",
            "type" => "Saída"
        ]);

        $report = (new Report())->find(
            "YEAR(data_report) = :year AND MONTH(data_report) = :month AND (historico = :historico OR historico = :historicoTwo) AND tipo = :type", 
            $params,
            "CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(SUM(valor), 2),'.',';'),',','.'),';',',')) as SALDO"
        )->fetch(true);

        $sheet->setCellValue('B' . $num_reports + 8, $report[0]->valor);
        */

        //Estilo
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

        for ($i = $num_reports + 5; $i <= $num_reports + 8; $i++) {
            $sheet->getRowDimension($i)->setRowHeight('20');
        }
        
        $sheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('63cbce');

        $sheet->getStyle('A' . ($num_reports + 5) . ':B' . ($num_reports + 8))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A' . ($num_reports + 5) . ':B' . ($num_reports + 5))->getFill()->getStartColor()->setARGB('ffffa6');
        $sheet->getStyle('A' . ($num_reports + 6) . ':B' . ($num_reports + 6))->getFill()->getStartColor()->setARGB('81d41a');
        $sheet->getStyle('A' . ($num_reports + 7) . ':B' . ($num_reports + 7))->getFill()->getStartColor()->setARGB('ff3838');
        $sheet->getStyle('A' . ($num_reports + 8) . ':B' . ($num_reports + 8))->getFill()->getStartColor()->setARGB('b4c7dc');

        $writer = new Xlsx($spreadsheet);

        $writer->save('files/Relatório - Mês ' . $current_month . ' de ' . $current_year . '.xlsx');
    }

}
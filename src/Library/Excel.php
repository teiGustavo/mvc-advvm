<?php

namespace Advvm\Library;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Advvm\DTOs\ReportDTO;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel
{
    private Worksheet $sheet;

    /**
     * @param array<ReportDTO> $reports
     */
    public function __construct(
        private Spreadsheet $spreadsheet,
        private array $reports
    ) {
        $this->sheet = $this->spreadsheet->getActiveSheet();
    }

    public function saveXlsx(string $filename): string
    {
        $writer = new Xlsx($this->spreadsheet);

        if (!str_contains($filename, '.xlsx')) {
            $filename .= '.xlsx';
        }

        $path = dirname(__DIR__, 2) . '/files/' . $filename;

        $this->generate();

        $writer->save($path);

        return '/files/' . $filename;
    }

    private function generate(): void
    {
        $reports = $this->reports;
        $num_reports = count($reports);
        $sheet = $this->sheet;

        //Definindo o título da planilha (conteúdo da célula A1)
        $sheet->setCellValue('A1', 'Relatório AD. Videira Verdadeira');

        //Cabeçalho da planilha
        $sheet->setCellValue('A2', 'DATA');
        $sheet->setCellValue('B2', 'HISTÓRICO');
        $sheet->setCellValue('C2', 'TIPO');
        $sheet->setCellValue('D2', 'VALOR');

        //Preenchendo as células da Planilha
        foreach ($reports as $key => $report) {
            $sheet->setCellValue('A' . ($key + 3), $report->getFormattedDate());
            $sheet->setCellValue('B' . ($key + 3), $report->getReport());
            $sheet->setCellValue('C' . ($key + 3), $report->getType());
            $sheet->setCellValue('D' . ($key + 3), $report->getAmount());
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

        $this->sheet = $sheet;
    }
}

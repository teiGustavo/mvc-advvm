<?php

namespace Advvm\Repositories\Report;

use Advvm\Models\Report;
use Advvm\DTOs\ReportDTO;

class ReportRepository implements ReportRepositoryInterface
{
    public function __construct(
        private Report $model
    ) {
    }

    public function createNewReport(ReportDTO $report): bool
    {
        $newReport = $this->model;

        $newReport->date = $report->getDate();
        $newReport->report = $report->getReport();
        $newReport->type = $report->getType();
        $newReport->amount = $report->getAmount();

        return $newReport->save();
    }

    public function findReportById(int $id): ?ReportDTO
    {
        $report = $this->model->findById($id);

        if ($report) {
            return new ReportDTO($report->date, $report->report, $report->type, $report->amount, $report->id);
        }

        return null;
    }

    public function getAllReports(int $limit = 6, int $offset = 0): array
    {
        $reports = $this->model
            ->find()
            ->limit($limit)
            ->offset($offset)
            ->fetch(true);

        if ($reports) {
            $array = [];

            foreach ($reports as $report) {
                $array[] = new ReportDTO($report->date, $report->report, $report->type, $report->amount, $report->id);
            }

            return $array;
        }

        return [];
    }

    public function updateReportById(ReportDTO $report, int $id): bool
    {
        $newReport = $this->model->findById($id);

        $newReport->date = $report->getDate();
        $newReport->report = $report->getReport();
        $newReport->type = $report->getType();
        $newReport->amount = $report->getAmount();

        return $newReport->save();
    }

    public function deleteReportById(int $id): bool
    {
        $report = $this->model->findById($id);

        if ($report) {
            return $report->destroy();
        }

        return false;
    }

    public function countAll(): int
    {
        return $this->model->find()->count();
    }

    public function getAllYearsOfReports(): array
    {
        $reports = $this->model->find("", "", "DISTINCT YEAR(date) as date")
            ->order("YEAR(date) DESC")
            ->fetch(true);

        if ($reports) {
            $filterOnlyYearInReport = function ($report) {
                return $report->date;
            };

            return array_map($filterOnlyYearInReport, $reports);
        }

        return [];
    }

    public function getFullNameOfMonthsOfReportsByYear(int $year): array
    {
        $paramsQuery = http_build_query(["year" => $year]);

        $reports = $this->model->find(
            "YEAR(date) = :year",
            $paramsQuery,
            "DISTINCT DATE_FORMAT(date, '%m') as date"
        )
            ->order("DATE_FORMAT(date, '%m')")
            ->fetch(true);

        if ($reports) {
            $filterMonthInReportAndTransformToFullName = function ($report) {
                return match ($report->date) {
                    '01' => 'janeiro',
                    '02' => 'fevereiro',
                    '03' => 'março',
                    '04' => 'abril',
                    '05' => 'maio',
                    '06' => 'junho',
                    '07' => 'julho',
                    '08' => 'agosto',
                    '09' => 'setembro',
                    '10' => 'outubro',
                    '11' => 'novembro',
                    '12' => 'dezembro',
                };
            };

            return array_map($filterMonthInReportAndTransformToFullName, $reports);
        }

        return [];
    }

    public function getAllReportsByYearAndMonthFullName(int $year, string $month): array
    {
        $params = http_build_query([
            "year" => $year,
            "month" => $month
        ]);

        $reports = $this->model
            ->find("YEAR(date) = :year AND DATE_FORMAT(date, '%M') = :month", $params)
            ->order("date")
            ->fetch(true);

        if ($reports) {
            $array = [];

            foreach ($reports as $key => $report) {
                $array[] = new ReportDTO($report->date, $report->report, $report->type, $report->amount, $report->id);
            }

            return $array;
        }

        return [];
    }
}

<?php

namespace Advvm\Repositories\Report;

use Advvm\Models\Report;
use Advvm\DTOs\ReportDTO;

interface ReportRepositoryInterface
{
    public function __construct(Report $model);
    public function createNewReport(ReportDTO $model): bool;
    public function findReportById(int $id): ?ReportDTO;

    /**
     * @return array<ReportDTO>
     */
    public function getAllReports(int $limit = 6, int $offset = 0): array;

    public function updateReportById(ReportDTO $report, int $id): bool;
    public function deleteReportById(int $id): bool;
    public function countAll(): int;

    /**
     * @return array<int>
     */
    public function getAllYearsOfReports(): array;

    /**
     * @return array<string>
     */
    public function getFullNameOfMonthsOfReportsByYear(int $year): array;

    /**
     * @return array<ReportDTO>
     */
    public function getAllReportsByYearAndMonthFullName(int $year, string $month): array;
}

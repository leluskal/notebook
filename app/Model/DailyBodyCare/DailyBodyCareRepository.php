<?php
declare(strict_types=1);

namespace App\Model\DailyBodyCare;

use App\Model\BaseRepository;

class DailyBodyCareRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'daily_body_care';
    }

    public function getById(int $id): ?DailyBodyCare
    {
        $row = $this->getDbConnection()->query('SELECT * FROM daily_body_care WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $dailyBodyCare = new DailyBodyCare(
            (int)$row->face_morning,
            (int)$row->face_evening,
            (int)$row->teeth_morning,
            (int)$row->teeth_evening,
            (int)$row->dental_hygiene,
            (int)$row->body_care,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyBodyCare->setId((int)$row->id);

        return $dailyBodyCare;
    }

    public function getByDayNumberAndMonthAndYear(int $dayNumber, int $month, int $year): ?DailyBodyCare
    {
        $row = $this->getDbConnection()
            ->query('SELECT * FROM daily_body_care WHERE day_number = ? AND month = ? AND year = ?',
                $dayNumber,
                $month,
                $year)
            ->fetch();

        if ($row === null) {
            return null;
        }

        $dailyBodyCare = new DailyBodyCare(
            (int)$row->face_morning,
            (int)$row->face_evening,
            (int)$row->teeth_morning,
            (int)$row->teeth_evening,
            (int)$row->dental_hygiene,
            (int)$row->body_care,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyBodyCare->setId((int)$row->id);

        return $dailyBodyCare;
    }

    public function findAllByDayNumberAndMonth(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM daily_body_care WHERE month = ? AND year = ?', $month, $year)->fetchAll();

        $dailyFaceCaresByDayNumber = [];

        foreach ($rows as $row) {

            $dailyFaceCaresByDayNumber[$row->day_number] = [
                'face_morning' => $row->face_morning,
                'face_evening' => $row->face_evening,
                'teeth_morning' => $row->teeth_morning,
                'teeth_evening' => $row->teeth_evening,
                'dental_hygiene' => $row->dental_hygiene,
                'body_care' => $row->body_care,
                'percentage' => $this->getCompletedPercentage($row),
            ];
        }

        return $dailyFaceCaresByDayNumber;
    }

    private function getCompletedPercentage($row): float
    {
        $columns = [
            'face_morning',
            'face_evening',
            'teeth_morning',
            'teeth_evening',
            'dental_hygiene',
            'body_care'
        ];

        $columnsCount = count($columns);
        $checkedCount = $this->getNumberOfCheckedBoxes($row);

        return $checkedCount / $columnsCount * 100;
    }

    private function getNumberOfCheckedBoxes($row): int
    {
        $columns = [
            'face_morning',
            'face_evening',
            'teeth_morning',
            'teeth_evening',
            'dental_hygiene',
            'body_care'
        ];

        $numberOfCheckedBoxes = 0;

        foreach ($columns as $column) {
            if ($row->$column == 1) {
                $numberOfCheckedBoxes++;
            }
        }

        return $numberOfCheckedBoxes;
    }

    public function getNumberOfRecords(int $month, int $year): int
    {
        $numberOfRecords = (int) $this->getDbConnection()
            ->query('SELECT COUNT(DISTINCT(day_number)) FROM daily_body_care WHERE month = ? AND year = ?',
                $month,
                $year)
            ->fetchSingle();

        return $numberOfRecords;
    }

    public function getNumberOfRecordsForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getNumberOfRecords($i, $year);
        }

        return $returnData;
    }

    public function getPercentageForMonth(int $month, int $year): float
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM daily_body_care WHERE month = ? AND year = ?', $month, $year)->fetchAll();

        $numberOfRecords = $this->getNumberOfRecords($month, $year);
        $totalPercentage = 0;

        foreach ($rows as $row) {
            $totalPercentage += $this->getCompletedPercentage($row);

        }

        if ($totalPercentage === 0) {
            return 0;
        }

        return $totalPercentage / $numberOfRecords;
    }

    public function getPercentageForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getPercentageForMonth($i, $year);
        }

        return $returnData;
    }

    public function getNumberOfRecordsByCreated($created): int
    {
        $numberOfRecords = (int) $this->getDbConnection()
            ->query('SELECT COUNT(DISTINCT(day_number)) FROM daily_body_care WHERE created = ?', $created)->fetchSingle();

        return $numberOfRecords;
    }

    public function getPercentageByCreated($created): float
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM daily_body_care WHERE created = ?', $created)->fetchAll();

        $numberOfRecords = $this->getNumberOfRecordsByCreated($created);
        $totalPercentage = 0;

        foreach ($rows as $row) {
            $totalPercentage += $this->getCompletedPercentage($row);

        }

        if ($totalPercentage === 0) {
            return 0;
        }

        return $totalPercentage / $numberOfRecords;
    }
}
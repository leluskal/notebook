<?php
declare(strict_types=1);

namespace App\Model\DailyNumberOfStep;

use App\Model\BaseRepository;

class DailyNumberOfStepRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'daily_number_of_step';
    }

    public function getById(int $id): ?DailyNumberOfStep
    {
        $row = $this->getDbConnection()->query('SELECT * FROM daily_number_of_step WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $dailyNumberOfStep = new DailyNumberOfStep(
            (int)$row->number,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyNumberOfStep->setId((int)$row->id);

        return $dailyNumberOfStep;
    }

    public function getByDayNumberAndMonthAndYear(int $dayNumber, int $month, int $year): ?DailyNumberOfStep
    {
        $row = $this->getDbConnection()
            ->query('SELECT * FROM daily_number_of_step WHERE day_number = ? AND month = ? AND year = ?',
                $dayNumber,
                $month,
                $year)
            ->fetch();

        if ($row === null) {
            return null;
        }

        $dailyNumberOfStep = new DailyNumberOfStep(
            (int)$row->number,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyNumberOfStep->setId((int)$row->id);

        return $dailyNumberOfStep;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM daily_number_of_step WHERE month = ? AND year = ?', $month, $year)->fetchAll();

        $dailyNumberOfStepsByDayNumber = [];

        foreach ($rows as $row) {
            $dailyNumberOfStepsByDayNumber[$row->day_number] = $row->number;
        }

        return $dailyNumberOfStepsByDayNumber;
    }

    public function getNumberOfRecords(int $month, int $year): int
    {
        $numberOfRecords = (int) $this->getDbConnection()
            ->query('SELECT COUNT(number) FROM daily_number_of_step WHERE month = ? AND year = ?', $month, $year)->fetchSingle();

        return $numberOfRecords;
    }

    public function getNumberOfRecordsForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <=12; $i++) {
            $returnData[$i] = $this->getNumberOfRecords($i, $year);
        }

        return $returnData;
    }

    public function getTotalSteps(int $month, int $year): int
    {
        $totalSteps = (int) $this->getDbConnection()
            ->query('SELECT SUM(number) FROM daily_number_of_step WHERE month = ? AND year = ?', $month, $year)->fetchSingle();

        return $totalSteps;
    }

    public function getTotalStepsForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getTotalSteps($i, $year);
        }

        return $returnData;
    }

    public function findAllByCreated($created): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM daily_number_of_step WHERE created = ?', $created)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function mapRowsToObjects(array $rows): array
    {
        $dailyNumberOfSteps = [];

        foreach ($rows as $row) {
            $dailyNumberOfStep = new DailyNumberOfStep(
                (int)$row->number,
                (int)$row->day_number,
                (int)$row->month,
                (int)$row->year,
                $row->created
            );
            $dailyNumberOfStep->setId((int)$row->id);

            $dailyNumberOfSteps[] = $dailyNumberOfStep;
        }

        return $dailyNumberOfSteps;
    }
}
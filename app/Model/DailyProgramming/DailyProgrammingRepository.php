<?php
declare(strict_types=1);

namespace App\Model\DailyProgramming;

use App\FrontModule\Components\Forms\DailyProgramming\DailyProgrammingForm;
use App\Model\BaseRepository;

class DailyProgrammingRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'daily_programming';
    }

    public function getById(int $id): ?DailyProgramming
    {
        $row = $this->getDbConnection()->query('SELECT * FROM daily_programming WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $dailyProgramming = new DailyProgramming(
            (int)$row->illness,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyProgramming->setId((int)$row->id);
        $dailyProgramming->setProgrammingDuration($row->programming_duration);
        $dailyProgramming->setDayType($row->day_type);
        $dailyProgramming->setDayPart($row->day_part);
        $dailyProgramming->setNote($row->note);

        return $dailyProgramming;
    }

    public function getByDayNumberAndMonthAndYear(int $dayNumber, int $month, int $year): ?DailyProgramming
    {
        $row = $this->getDbConnection()
            ->query('SELECT * FROM daily_programming WHERE day_number = ? AND month = ? AND year = ?',
                $dayNumber,
                $month,
                $year)
            ->fetch();

        if ($row === null) {
            return null;
        }

        $dailyProgramming = new DailyProgramming(
            (int)$row->illness,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyProgramming->setId((int)$row->id);
        $dailyProgramming->setProgrammingDuration($row->programming_duration);
        $dailyProgramming->setDayType($row->day_type);
        $dailyProgramming->setDayPart($row->day_part);
        $dailyProgramming->setNote($row->note);

        return $dailyProgramming;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM daily_programming WHERE month = ? AND year = ?', $month, $year)->fetchAll();

        $dailyProgrammingsByDayNumber = [];

        foreach ($rows as $row) {
            $dailyProgrammingsByDayNumber[$row->day_number] = [
                'programming_duration' => $row->programming_duration,
                'day_type' => $row->day_type,
                'day_part' => $row->day_part,
                'note' => $row->note,
                'illness' => $row->illness,
            ];
        }

        return $dailyProgrammingsByDayNumber;
    }

    public function getNumberOfRecords(int $month, int $year): int
    {
        $numberOfRecords = $this->getDbConnection()
            ->query('SELECT COUNT(programming_duration) FROM daily_programming WHERE programming_duration != 0 AND month = ? AND year = ?',
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

    public function getTotalProgrammingTime(int $month, int $year): int
    {
        $totalTime = (int) $this->getDbConnection()
            ->query('SELECT SUM(programming_duration) FROM daily_programming WHERE month = ? AND year = ?', $month, $year)
            ->fetchSingle();

        return $totalTime;
    }

    public function getTotalProgrammingTimeForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getTotalProgrammingTime($i, $year);
        }

        return $returnData;
    }

    public function findAllByCreated($created): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM daily_programming WHERE created = ?', $created)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function mapRowsToObjects(array $rows): array
    {
        $dailyProgrammings = [];

        foreach ($rows as $row) {
            $dailyProgramming = new DailyProgramming(
                (int)$row->illness,
                (int)$row->day_number,
                (int)$row->month,
                (int)$row->year,
                $row->created
            );
            $dailyProgramming->setId((int)$row->id);
            $dailyProgramming->setProgrammingDuration($row->programming_duration);
            $dailyProgramming->setDayType($row->day_type);
            $dailyProgramming->setDayPart($row->day_part);
            $dailyProgramming->setNote($row->note);

            $dailyProgrammings[] = $dailyProgramming;
        }

        return $dailyProgrammings;
    }

}
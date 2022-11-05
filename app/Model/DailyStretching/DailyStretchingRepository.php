<?php
declare(strict_types=1);

namespace App\Model\DailyStretching;

use App\Model\BaseRepository;

class DailyStretchingRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'daily_stretching';
    }

    public function getById(int $id): ?DailyStretching
    {
        $row = $this->getDbConnection()->query('SELECT * FROM daily_stretching WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $dailyStretching = new DailyStretching(
            (int)$row->illness,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyStretching->setId((int)$row->id);
        $dailyStretching->setStretchTime($row->stretch_time);
        $dailyStretching->setDayType($row->day_type);
        $dailyStretching->setDayPart($row->day_part);
        $dailyStretching->setNote($row->note);

        return $dailyStretching;
    }

    public function getByDayNumberAndMonthAndYear(int $dayNumber, int $month, int $year): ?DailyStretching
    {
        $row = $this->getDbConnection()
            ->query('SELECT * FROM daily_stretching WHERE day_number = ? AND month = ? AND year = ?',
                $dayNumber,
                $month,
                $year)
            ->fetch();

        if ($row === null) {
            return null;
        }

        $dailyStretching = new DailyStretching(
            (int)$row->illness,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyStretching->setId((int)$row->id);
        $dailyStretching->setStretchTime($row->stretch_time);
        $dailyStretching->setDayType($row->day_type);
        $dailyStretching->setDayPart($row->day_part);
        $dailyStretching->setNote($row->note);

        return $dailyStretching;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM daily_stretching WHERE month = ? AND year = ?', $month, $year)->fetchAll();

        $dailyStretchingsByDayNumber = [];

        foreach ($rows as $row) {
            $dailyStretchingsByDayNumber[$row->day_number] = [
                'stretch_time' => $row->stretch_time,
                'day_type' => $row->day_type,
                'day_part' => $row->day_part,
                'note' => $row->note,
                'illness' => $row->illness,
            ];
        }

        return $dailyStretchingsByDayNumber;
    }

    public function getNumberOfRecords(int $month, int $year): int
    {
        $numberOfRecords = (int) $this->getDbConnection()
            ->query('SELECT COUNT(DISTINCT(day_number)) FROM daily_stretching WHERE month = ? AND year = ? AND stretch_time != 0',
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

    public function getTotalStretchingTime(int $month, int $year): int
    {
        $totalTime = (int) $this->getDbConnection()
            ->query('SELECT SUM(stretch_time) FROM daily_stretching WHERE month = ? AND year = ?', $month, $year)
            ->fetchSingle();

        return $totalTime;
    }

    public function getTotalStretchingTimeForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getTotalStretchingTime($i, $year);
        }

        return $returnData;
    }

    public function findAllByCreated($created): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM daily_stretching WHERE created =?', $created)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function mapRowsToObjects(array $rows): array
    {
        $dailyStretchings = [];

        foreach ($rows as $row) {
            $dailyStretching = new DailyStretching(
                (int)$row->illness,
                (int)$row->day_number,
                (int)$row->month,
                (int)$row->year,
                $row->created
            );
            $dailyStretching->setId((int)$row->id);
            $dailyStretching->setStretchTime($row->stretch_time);
            $dailyStretching->setDayType($row->day_type);
            $dailyStretching->setDayPart($row->day_part);
            $dailyStretching->setNote($row->note);

            $dailyStretchings[] = $dailyStretching;
        }

        return $dailyStretchings;
    }
}
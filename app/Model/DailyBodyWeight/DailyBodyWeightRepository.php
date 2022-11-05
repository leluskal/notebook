<?php
declare(strict_types=1);

namespace App\Model\DailyBodyWeight;

use App\Model\BaseRepository;

class DailyBodyWeightRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'daily_body_weight';
    }

    public function getById(int $id): ?DailyBodyWeight
    {
        $row = $this->getDbConnection()->query('SELECT * FROM daily_body_weight WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $dailyBodyWeight = new DailyBodyWeight(
            (float)$row->number,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyBodyWeight->setId((int)$row->id);

        return $dailyBodyWeight;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM daily_body_weight WHERE month = ? AND year = ?',
                $month,
                $year)
            ->fetchAll();

        $weightsGroupedByDayNumber = [];

        foreach ($rows as $row) {
            $weightsGroupedByDayNumber[$row->day_number]= $row->number;
        }

        return $weightsGroupedByDayNumber;
    }

    public function getByDayNumberAndMonthAndYear(int $dayNumber, int $month, int $year): ?DailyBodyWeight
    {
        $row = $this->getDbConnection()
            ->query('SELECT * FROM daily_body_weight WHERE day_number = ? AND month = ? AND year = ?',
                $dayNumber,
                $month,
                $year)
            ->fetch();

        if ($row === null) {
            return null;
        }

        $dailyBodyWeight = new DailyBodyWeight(
            (float)$row->number,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyBodyWeight->setId((int)$row->id);

        return $dailyBodyWeight;
    }
}
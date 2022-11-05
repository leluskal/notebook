<?php
declare(strict_types=1);

namespace App\Model\DailyEating;

use App\Model\BaseRepository;

class DailyEatingRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'daily_eating';
    }

    public function getById(int $id): ?DailyEating
    {
        $row = $this->getDbConnection()->query('SELECT * FROM daily_eating WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $dailyEating = new DailyEating(
            (int)$row->calorie_number,
            (int)$row->calorie_estimate,
            (int)$row->outside_food,
            (string)$row->day_type,
            (int)$row->illness,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyEating->setId((int)$row->id);
        $dailyEating->setNote($row->note);

        return $dailyEating;
    }

    public function getByDayNumberAndMonthAndYear(int $dayNumber, int $month, int $year): ?DailyEating
    {
        $row = $this->getDbConnection()
            ->query('SELECT * FROM daily_eating WHERE day_number = ? AND month = ? AND year = ?',
                $dayNumber,
                $month,
                $year)
            ->fetch();

        if ($row === null) {
            return null;
        }

        $dailyEating = new DailyEating(
            (int)$row->calorie_number,
            (int)$row->calorie_estimate,
            (int)$row->outside_food,
            (string)$row->day_type,
            (int)$row->illness,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $dailyEating->setId((int)$row->id);
        $dailyEating->setNote($row->note);

        return $dailyEating;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM daily_eating WHERE month = ? AND year = ?',
            $month,
            $year)
            ->fetchAll();

        $dailyEatingsByDayNumber = [];

        foreach ($rows as $row) {
            $dailyEatingsByDayNumber[$row->day_number] = [
                'calorie_number' => $row->calorie_number,
                'calorie_estimate' => $row->calorie_estimate,
                'outside_food' => $row->outside_food,
                'day_type' => $row->day_type,
                'illness' => $row->illness,
                'note' => $row->note,
            ];
        }

        return $dailyEatingsByDayNumber;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $dailyEatings = [];

        foreach ($rows as $row) {
            $dailyEating = new DailyEating(
                (int)$row->calorie_number,
                (int)$row->calorie_estimate,
                (int)$row->outside_food,
                (string)$row->day_type,
                (int)$row->illness,
                (int)$row->day_number,
                (int)$row->month,
                (int)$row->year,
                $row->created
        );
            $dailyEating->setId((int)$row->id);
            $dailyEating->setNote($row->note);

            $dailyEatings[] = $dailyEating;
        }

        return $dailyEatings;
    }

    public function getNumberOfEatingRecords(int $month, int $year): int
    {
        $numberOfEatingRecords = (int) $this->getDbConnection()
            ->query('SELECT COUNT(calorie_number) FROM daily_eating WHERE month = ? AND year = ?', $month, $year)
            ->fetchSingle();

        return $numberOfEatingRecords;
    }

    public function getNumberOfEatingRecordsForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <=12; $i ++) {
            $returnData[$i] = $this->getNumberOfEatingRecords($i, $year);
        }

        return $returnData;
    }

    public function getCaloricDeficit(int $month, int $year): int
    {
        $eatingCalorie = (int) $this->getDbConnection()
            ->query('SELECT SUM(calorie_number) FROM daily_eating WHERE month = ? AND year = ?', $month, $year)
            ->fetchSingle();

        $totalCalories = 1830 * $this->getNumberOfEatingRecords($month, $year);

        $caloricDeficit = $totalCalories - $eatingCalorie;

        return $caloricDeficit * -1;
    }

    public function getCaloricDeficitForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getCaloricDeficit($i, $year);
        }

        return $returnData;
    }

    public function findAllByCreated($created): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM daily_eating WHERE created = ?', $created)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }
}
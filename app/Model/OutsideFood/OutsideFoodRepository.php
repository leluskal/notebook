<?php
declare(strict_types=1);

namespace App\Model\OutsideFood;

use App\Model\BaseRepository;

class OutsideFoodRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'outside_food';
    }

    public function getById(int $id): ?OutsideFood
    {
        $row = $this->getDbConnection()->query('SELECT * FROM outside_food WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $outsideFood = new OutsideFood(
            (string)$row->food,
            (int)$row->price,
            (int)$row->food_delivery,
            (int)$row->drink,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $outsideFood->setId((int)$row->id);
        $outsideFood->setNote($row->note);

        return $outsideFood;
    }

    public function getByDayNumberAndMonthAndYear(int $dayNumber, int $month, int $year): ?OutsideFood
    {
        $row = $this->getDbConnection()
            ->query('SELECT * FROM outside_food WHERE day_number = ? AND month = ? AND year = ?',
                $dayNumber,
                $month,
                $year)
            ->fetch();

        if ($row === null) {
            return null;
        }

        $outsideFood = new OutsideFood(
            (string)$row->food,
            (int)$row->price,
            (int)$row->food_delivery,
            (int)$row->drink,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $outsideFood->setId((int)$row->id);
        $outsideFood->setNote($row->note);

        return $outsideFood;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM outside_food WHERE month = ? AND year = ?',
                $month,
                $year)
            ->fetchAll();

        $outsideFoodByDayNumber = [];

        foreach ($rows as $row) {
            $outsideFoodByDayNumber[$row->day_number][] = [
                'id' => $row->id,
                'food' => $row->food,
                'price' => $row->price,
                'food_delivery' => $row->food_delivery,
                'drink' => $row->drink
            ];
        }

        return $outsideFoodByDayNumber;
    }

    public function getNumberOfFoodRecords(int $month, int $year): int
    {
        $numberOfRecords = (int) $this->getDbConnection()
            ->query('SELECT COUNT(DISTINCT(id)) FROM outside_food WHERE month = ? AND year = ? AND drink = 0',
                $month,
                $year)
            ->fetchSingle();

        return $numberOfRecords;
    }

    public function getNumberOfFoodRecordsForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getNumberOfFoodRecords($i, $year);
        }

        return $returnData;
    }

    public function getNumberOfDrinkRecords(int $month, int $year): int
    {
        $numberOfRecords = (int) $this->getDbConnection()
            ->query('SELECT COUNT(DISTINCT(id)) FROM outside_food WHERE month = ? AND year = ? AND drink = 1',
                $month,
                $year)
            ->fetchSingle();

        return $numberOfRecords;
    }

    public function getNumberOfDrinkRecordsForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getNumberOfDrinkRecords($i, $year);
        }

        return $returnData;
    }

    public function getTotalSpentMoney(int $month, int $year): int
    {
        $totalTime = (int) $this->getDbConnection()
            ->query('SELECT SUM(price) FROM outside_food WHERE month = ? AND year = ?', $month, $year)
            ->fetchSingle();

        return $totalTime;
    }

    public function getTotalSpentMoneyForAllMonths(int $year): array
    {
        $returnData = [];

        for ($i = 1; $i <= 12; $i++) {
            $returnData[$i] = $this->getTotalSpentMoney($i, $year);
        }

        return $returnData;
    }
}
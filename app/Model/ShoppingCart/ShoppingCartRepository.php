<?php
declare(strict_types=1);

namespace App\Model\ShoppingCart;

use App\Model\BaseRepository;

class ShoppingCartRepository extends BaseRepository
{

    public function getTableName(): string
    {
        return 'shopping_cart';
    }

    public function getById(int $id): ?ShoppingCart
    {
        $row = $this->getDbConnection()->query('SELECT * FROM shopping_cart WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $shoppingCart = new ShoppingCart(
            (string)$row->shop,
            (int)$row->price,
            (int)$row->day_number,
            (int)$row->month,
            (int)$row->year,
            $row->created
        );
        $shoppingCart->setId((int)$row->id);
        $shoppingCart->setNote($row->note);

        return $shoppingCart;
    }

    public function findAllByMonthAndYear(int $month, int $year): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM shopping_cart WHERE month = ? AND year = ?', $month, $year)->fetchAll();

        $shoppingCartsByDayNumber = [];

        foreach ($rows as $row) {
            $shoppingCartsByDayNumber[$row->day_number][] = [
                'id' => $row->id,
                'shop' => $row->shop,
                'price' => $row->price,
                'note' => $row->note
            ];
        }

        return $shoppingCartsByDayNumber;
    }

    public function getNumberOfRecords(int $month, int $year): int
    {
        $numberOfRecords = (int) $this->getDbConnection()
            ->query('SELECT COUNT(DISTINCT(id)) FROM shopping_cart WHERE month = ? AND year = ?',
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

    public function getTotalSpentMoney(int $month, int $year): int
    {
        $totalMoney = (int) $this->getDbConnection()
            ->query('SELECT SUM(price) FROM shopping_cart WHERE month = ? AND year = ?', $month, $year)
            ->fetchSingle();

        return $totalMoney;
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
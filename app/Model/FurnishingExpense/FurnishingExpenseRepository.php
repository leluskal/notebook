<?php
declare(strict_types=1);

namespace App\Model\FurnishingExpense;

use App\Model\BaseRepository;

class FurnishingExpenseRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'furnishing_expense';
    }

    public function getById(int $id): ?FurnishingExpense
    {
        $row = $this->getDbConnection()->query('SELECT * FROM furnishing_expense WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $furnishingExpense = new FurnishingExpense(
            (string)$row->furnishings,
            (int)$row->price
        );
        $furnishingExpense->setId((int)$row->id);
        $furnishingExpense->setNote($row->note);

        return $furnishingExpense;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $furnishingExpenses = [];

        foreach ($rows as $row) {
            $furnishingExpense = new FurnishingExpense(
                (string)$row->furnishings,
                (int)$row->price
            );
            $furnishingExpense->setId((int)$row->id);
            $furnishingExpense->setNote($row->note);

            $furnishingExpenses[] = $furnishingExpense;
        }

        return $furnishingExpenses;
    }

    /**
     * @return FurnishingExpense[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM furnishing_expense')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function getTotalSpentMoney(): int
    {
        $totalMoney = (int) $this->getDbConnection()
            ->query('SELECT SUM(price) FROM furnishing_expense')->fetchSingle();

        return $totalMoney;
    }
}
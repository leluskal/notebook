<?php
declare(strict_types=1);

namespace App\Model\Entertainment;

use App\Model\BaseRepository;

class EntertainmentRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'entertainment';
    }

    public function getById(int $id): ?Entertainment
    {
        $row = $this->getDbConnection()->query('SELECT * FROM entertainment WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $entertainment = new Entertainment(
            (int)$row->entertainment_type_id,
            $row->date,
            (string)$row->details,
            (string)$row->month,
            (int)$row->year,
            (int)$row->rating
        );
        $entertainment->setId((int)$row->id);

        return $entertainment;
    }

    public function findAllByYearAndMonth(int $year, string $month): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM entertainment WHERE year = ? AND month = ?', $year, $month)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function mapRowsToObjects(array $rows): array
    {
        $entertainments = [];

        foreach ($rows as $row) {
            $entertainment = new Entertainment(
                (int)$row->entertainment_type_id,
                $row->date,
                (string)$row->details,
                (string)$row->month,
                (int)$row->year,
                (int)$row->rating
            );
            $entertainment->setId((int)$row->id);

            $entertainments[] = $entertainment;
        }

        return $entertainments;
    }
}
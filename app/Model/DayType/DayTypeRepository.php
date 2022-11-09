<?php
declare(strict_types=1);

namespace App\Model\DayType;

use App\Model\BaseRepository;

class DayTypeRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'day_type';
    }

    public function getById(int $id): ?DayType
    {
        $row = $this->getDbConnection()->query('SELECT * FROM day_type WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $dayType = new DayType(
            (string)$row->name,
            (int)$row->work_day,
            $row->created,
            (int)$row->year
        );
        $dayType->setId((int)$row->id);

        return $dayType;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $dayTypes = [];

        foreach ($rows as $row) {
            $dayType = new DayType(
                (string)$row->name,
                (int)$row->work_day,
                $row->created,
                (int)$row->year
            );
            $dayType->setId((int)$row->id);

            $dayTypes[] = $dayType;
        }

        return $dayTypes;
    }

    public function findAllByCreated($created): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM day_type WHERE created = ?', $created)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }
}
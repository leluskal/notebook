<?php
declare(strict_types=1);

namespace App\Model\ApartmentList;

use App\Model\BaseRepository;

class ApartmentListRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'apartment_list';
    }

    public function getById(int $id): ?ApartmentList
    {
        $row = $this->getDbConnection()->query('SELECT * FROM apartment_list WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $apartmentList = new ApartmentList(
            (string)$row->name,
            (int)$row->done
        );
        $apartmentList->setId((int)$row->id);

        return $apartmentList;
    }

    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM apartment_list ORDER BY id DESC')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function mapRowsToObjects(array $rows): array
    {
        $apartmentLists = [];

        foreach ($rows as $row) {
            $apartmentList = new ApartmentList(
                (string)$row->name,
                (int)$row->done
            );
            $apartmentList->setId((int)$row->id);

            $apartmentLists[] = $apartmentList;
        }

        return $apartmentLists;
    }
}
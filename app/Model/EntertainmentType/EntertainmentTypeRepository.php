<?php
declare(strict_types=1);

namespace App\Model\EntertainmentType;

use App\Model\BaseRepository;

class EntertainmentTypeRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'entertainment_type';
    }

    public function getById(int $id): ?EntertainmentType
    {
        $row = $this->getDbConnection()->query('SELECT * FROM entertainment_type WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $entertainmentType = new EntertainmentType(
            (string)$row->name
        );
        $entertainmentType->setId((int)$row->id);

        return $entertainmentType;
    }

    /**
     * @return EntertainmentType[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM entertainment_type')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $entertainmentTypes = $this->findAll();

        $returnArray = [];

        foreach ($entertainmentTypes as $type) {
            $returnArray[$type->getId()] = $type->getName();
        }

        return $returnArray;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $entertainmentTypes = [];

        foreach ($rows as $row) {
            $entertainmentType = new EntertainmentType(
                (string)$row->name
            );
            $entertainmentType->setId((int)$row->id);

            $entertainmentTypes[] = $entertainmentType;
        }

        return $entertainmentTypes;
    }
}
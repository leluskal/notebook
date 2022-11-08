<?php
declare(strict_types=1);

namespace App\Model\DestinationType;

use App\Model\BaseRepository;

class DestinationTypeRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'destination_type';
    }

    public function getById(int $id): ?DestinationType
    {
        $row = $this->getDbConnection()->query('SELECT * FROM destination_type WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $destinationType = new DestinationType(
            (string)$row->name
        );
        $destinationType->setId((int)$row->id);

        return $destinationType;
    }

    /**
     * @return DestinationType[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM destination_type')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $destinationTypes = $this->findAll();

        $returnArray = [];

        foreach ($destinationTypes as $type) {
            $returnArray[$type->getId()] = $type->getName();
        }

        return $returnArray;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $destinationTypes = [];

        foreach ($rows as $row) {
            $destinationType = new DestinationType(
                (string)$row->name
            );
            $destinationType->setId((int)$row->id);

            $destinationTypes[] = $destinationType;
        }

        return $destinationTypes;
    }
}
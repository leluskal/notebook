<?php
declare(strict_types=1);

namespace App\Model\TransportType;

use App\Model\BaseRepository;

class TransportTypeRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'transport_type';
    }

    public function getById(int $id): ?TransportType
    {
        $row = $this->getDbConnection()->query('SELECT * FROM transport_type WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $transportType = new TransportType(
            (string)$row->name
        );
        $transportType->setId((int)$row->id);

        return $transportType;
    }

    /**
     * @return TransportType[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM transport_type')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $transportTypes = $this->findAll();

        $returnArray = [];

        foreach ($transportTypes as $type) {
            $returnArray[$type->getId()] = $type->getName();
        }

        return $returnArray;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $transportTypes = [];

        foreach ($rows as $row) {
            $transportType = new TransportType(
                (string)$row->name
            );
            $transportType->setId((int)$row->id);

            $transportTypes[] = $transportType;
        }

        return $transportTypes;
    }
}
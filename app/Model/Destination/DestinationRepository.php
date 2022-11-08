<?php
declare(strict_types=1);

namespace App\Model\Destination;

use App\Model\BaseRepository;

class DestinationRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'destination';
    }

    public function getById(int $id): ?Destination
    {
        $row = $this->getDbConnection()->query('SELECT * FROM destination WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $destination = new Destination(
            (string)$row->name,
            (int)$row->destination_type_id,
            (string)$row->nearby_city,
            (int)$row->distance_from_home,
            (int)$row->visited
        );
        $destination->setId((int)$row->id);
        $destination->setDetails($row->details);

        return $destination;
    }

    public function findAllByDestinationTypeId(int $destinationTypeId): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM destination WHERE destination_type_id = ?', $destinationTypeId)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    /**
     * @return Destination[]
     * @throws \Dibi\Exception
     */
    public function findAll()
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM destination')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }


    public function findAllForSelectBox(): array
    {
        $destinations = $this->findAll();

        $returnArray = [];

        foreach ($destinations as $destination) {
            $returnArray[$destination->getId()] = $destination->getName();
        }

        return $returnArray;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $destinations = [];

        foreach ($rows as $row) {
            $destination = new Destination(
                (string)$row->name,
                (int)$row->destination_type_id,
                (string)$row->nearby_city,
                (int)$row->distance_from_home,
                (int)$row->visited
            );
            $destination->setId((int)$row->id);
            $destination->setDetails($row->details);

            $destinations[] = $destination;
        }

        return $destinations;
    }
}
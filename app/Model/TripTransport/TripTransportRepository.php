<?php
declare(strict_types=1);

namespace App\Model\TripTransport;

use App\Model\BaseRepository;

class TripTransportRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'trip_transport';
    }

    public function getById(int $id): ?TripTransport
    {
        $row = $this->getDbConnection()->query('SELECT * FROM trip_transport WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $tripTransport = new TripTransport(
            (int)$row->trip_id,
            (int)$row->transport_type_id
        );
        $tripTransport->setId((int)$row->id);

        return $tripTransport;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $tripTransports = [];

        foreach ($rows as $row) {
            $tripTransport = new TripTransport(
                (int)$row->trip_id,
                (int)$row->transport_type_id
            );
            $tripTransport->setId((int)$row->id);

            $tripTransports[] = $tripTransport;
        }

        return $tripTransports;
    }

    public function deleteAllByTripId(int $tripId): void
    {
        $this->getDbConnection()->query('DELETE FROM trip_transport WHERE trip_id = ?', $tripId);
    }

    public function getAllTransportIdsByTripId(int $tripId): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT transport_type_id FROM trip_transport WHERE trip_id = ?', $tripId)
            ->fetchAll();

        $returnArray = [];

        foreach ($rows as $row) {
          $returnArray[] = $row->transport_type_id;
        }

        return $returnArray;
    }
}
<?php
declare(strict_types=1);

namespace App\Model\Trip;

use App\Model\BaseRepository;

class TripRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'trip';
    }

    public function getById(int $id): ?Trip
    {
        $row = $this->getDbConnection()->query('SELECT * FROM trip WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $trip = new Trip(
            $row->date,
            (string)$row->destination,
            $row->start_of_trip,
            $row->end_of_trip,
            (int)$row->rating,
            (int)$row->year,
            (string)$row->month,
            (string)$row->details
        );
        $trip->setId((int)$row->id);

        return $trip;
    }

    public function findAllForSelectBox(): array
    {
        $trips = $this->findAll();

        $returnArray = [];

        foreach ($trips as $trip) {
            $returnArray[$trip->getId()] = $trip->getDate()->format('d.m.Y');
        }

        return $returnArray;
    }

    public function findAllByYearAndMonth(int $year, string $month): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM trip WHERE year = ? AND month = ?', $year, $month)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    /**
     * @return Trip[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM trip')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function mapRowsToObjects(array $rows): array
    {
        $trips = [];

        foreach ($rows as $row) {
            $trip = new Trip(
                $row->date,
                (string)$row->destination,
                $row->start_of_trip,
                $row->end_of_trip,
                (int)$row->rating,
                (int)$row->year,
                (string)$row->month,
                (string)$row->details
            );
            $trip->setId((int)$row->id);

            $trips[] = $trip;
        }

        return $trips;
    }

    public function findAllGroupedByMonth(int $year, string $month): array
    {
        $trips = $this->findAllByYearAndMonth($year, $month);

        $tripsGroupedByMonth = [];

        foreach ($trips as $trip) {
            $month = $trip->getMonth();
            $tripsGroupedByMonth[$month][] = $trip;
        }

        return $tripsGroupedByMonth;
    }
}
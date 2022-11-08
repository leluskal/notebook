<?php
declare(strict_types=1);

namespace App\Model\Room;

use App\Model\BaseRepository;

class RoomRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'room';
    }

    public function getById(int $id): ?Room
    {
        $row = $this->getDbConnection()->query('SELECT * FROM room WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $room = new Room(
            (string)$row->name
        );
        $room->setId((int)$row->id);

        return $room;
    }

    /**
     * @return Room[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM room')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $rooms = $this->findAll();

        $returnArray = [];

        foreach ($rooms as $room) {
            $returnArray[$room->getId()] = $room->getName();
        }

        return $returnArray;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $rooms = [];

        foreach ($rows as $row) {
            $room = new Room(
                (string)$row->name
            );
            $room->setId((int)$row->id);

            $rooms[] = $room;
        }

        return $rooms;
    }
}
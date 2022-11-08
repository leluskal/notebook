<?php
declare(strict_types=1);

namespace App\Model\Furnishing;

use App\Model\BaseRepository;

class FurnishingRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'furnishing';
    }

    public function getById(int $id): ?Furnishing
    {
        $row = $this->getDbConnection()->query('SELECT * FROM furnishing WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $furnishing = new Furnishing(
            (int)$row->furnishing_category_id,
            (string)$row->name
        );
        $furnishing->setId((int)$row->id);
        $furnishing->setNote($row->note);

        return $furnishing;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $furnishings = [];

        foreach ($rows as $row) {
            $furnishing = new Furnishing(
                (int)$row->furnishing_category_id,
                (string)$row->name
            );
            $furnishing->setId((int)$row->id);
            $furnishing->setNote($row->note);

            $furnishings[] = $furnishing;
        }

        return $furnishings;
    }

    /**
     * @return Furnishing[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM furnishing')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllByFurnishingCategoryId(int $furnishingCategoryId): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM furnishing WHERE furnishing_category_id = ? ORDER BY name ASC', $furnishingCategoryId)
            ->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $furnishings = $this->findAll();

        $returnArray = [];

        foreach ($furnishings as $furnishing) {
            $returnArray[$furnishing->getId()] = $furnishing->getName();
        }

        return $returnArray;
    }
}
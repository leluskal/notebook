<?php
declare(strict_types=1);

namespace App\Model\FurnishingCategory;

use App\Model\BaseRepository;

class FurnishingCategoryRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'furnishing_category';
    }

    public function getById(int $id): ?FurnishingCategory
    {
        $row = $this->getDbConnection()->query('SELECT * FROM furnishing_category WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $furnishingCategory = new FurnishingCategory(
            (string)$row->name
        );
        $furnishingCategory->setId((int)$row->id);

        return $furnishingCategory;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $furnishingCategories = [];

        foreach ($rows as $row) {
            $furnishingCategory = new FurnishingCategory(
                (string)$row->name
            );
            $furnishingCategory->setId((int)$row->id);

            $furnishingCategories[] = $furnishingCategory;
        }

        return $furnishingCategories;
    }

    /**
     * @return FurnishingCategory[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM furnishing_category')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $furnishingCategories = $this->findAll();

        $returnArray = [];

        foreach ($furnishingCategories as $furnishingCategory) {
            $returnArray[$furnishingCategory->getId()] = $furnishingCategory->getName();
        }

        return $returnArray;
    }
}
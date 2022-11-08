<?php
declare(strict_types=1);

namespace App\Model\Ingredient;

use App\Model\BaseRepository;

class IngredientRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'ingredient';
    }

    public function getById(int $id): ?Ingredient
    {
        $row = $this->getDbConnection()->query('SELECT * FROM ingredient WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $ingredient = new Ingredient(
            (string)$row->name
        );
        $ingredient->setId((int)$row->id);

        return $ingredient;
    }

    /**
     * @return Ingredient[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM ingredient')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    /**
     * @param string $sort
     * @return Ingredient[]
     * @throws \Dibi\Exception
     */
    public function findAllSortedByName(string $sort = 'ASC'): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM ingredient ORDER BY name ' . $sort)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $ingredients = $this->findAll();

        $returnArray = [];

        foreach ($ingredients as $ingredient) {
            $returnArray[$ingredient->getId()] = $ingredient->getName();
        }

        return $returnArray;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $ingredients = [];

        foreach ($rows as $row) {
            $ingredient = new Ingredient(
                (string)$row->name
            );
            $ingredient->setId((int)$row->id);

            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }

    public function findAllByFirstCharacter(): array
    {
        $ingredients = $this->findAllSortedByName();

        $returnArray = [];

        foreach ($ingredients as $ingredient) {
            $firstCharacter = substr($ingredient->getName(), 0, 1);

            $returnArray[$firstCharacter][] = $ingredient;
        }

        return $returnArray;
    }
}
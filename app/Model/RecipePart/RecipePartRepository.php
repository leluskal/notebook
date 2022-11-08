<?php
declare(strict_types=1);

namespace App\Model\RecipePart;

use App\Model\BaseRepository;

class RecipePartRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'recipe_part';
    }

    public function getById(int $id): ?RecipePart
    {
        $row = $this->getDbConnection()->query('SELECT * FROM recipe_part WHERE id = ?', $id)->fetch();

        if ($row === null) {
          return null;
        }

        $recipePart = new RecipePart(
            (int)$row->recipe_id,
            (string)$row->name
        );
        $recipePart->setId((int)$row->id);

        return $recipePart;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $recipeParts = [];

        foreach ($rows as $row) {
            $recipePart = new RecipePart(
                (int)$row->recipe_id,
                (string)$row->name
            );
            $recipePart->setId((int)$row->id);

            $recipeParts[] = $recipePart;
        }

        return $recipeParts;
    }

    public function findAllByRecipeId(int $recipeId): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM recipe_part WHERE recipe_id = ?', $recipeId)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    /**
     * @return RecipePart[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM recipe_part')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(int $recipeId): array
    {
        $recipeParts = $this->findAllByRecipeId($recipeId);

        $returnArray = [];

        foreach ($recipeParts as $recipePart) {
            $returnArray[$recipePart->getId()] = $recipePart->getName();
        }

        return $returnArray;
    }

    public function getByRecipeId(int $recipeId): ?RecipePart
    {
        $row = $this->getDbConnection()->query('SELECT * FROM recipe_part WHERE recipe_id = ?', $recipeId)->fetch();

        if ($row === null) {
            return null;
        }

        $recipePart = new RecipePart(
            (int)$row->recipe_id,
            (string)$row->name
        );
        $recipePart->setId((int)$row->id);

        return $recipePart;
    }
}
<?php
declare(strict_types=1);

namespace App\Model\RecipePartMethod;

use App\Model\BaseRepository;

class RecipePartMethodRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'recipe_part_method';
    }

    public function getById(int $id): ?RecipePartMethod
    {
        $row = $this->getDbConnection()->query('SELECT * FROM recipe_part_method WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $recipePartMethod = new RecipePartMethod(
            (int)$row->recipe_part_id,
            (int)$row->sort,
            (string)$row->method
        );
        $recipePartMethod->setId((int)$row->id);

        return $recipePartMethod;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $recipePartMethods = [];

        foreach ($rows as $row) {
            $recipePartMethod = new RecipePartMethod(
                (int)$row->recipe_part_id,
                (int)$row->sort,
                (string)$row->method
            );
            $recipePartMethod->setId((int)$row->id);

            $recipePartMethods[] = $recipePartMethod;
        }

        return $recipePartMethods;
    }

    public function findAllByRecipePartId(int $recipePartId): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM recipe_part_method WHERE recipe_part_id = ?', $recipePartId)
            ->fetchAll();

        return $this->mapRowsToObjects($rows);
    }
}
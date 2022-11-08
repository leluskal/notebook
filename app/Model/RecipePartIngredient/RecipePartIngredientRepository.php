<?php
declare(strict_types=1);

namespace App\Model\RecipePartIngredient;

use App\Model\BaseRepository;

class RecipePartIngredientRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'recipe_part_ingredient';
    }

    public function getById(int $id): ?RecipePartIngredient
    {
        $row = $this->getDbConnection()->query('SELECT * FROM recipe_part_ingredient WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $recipePartIngredient = new RecipePartIngredient(
            (int)$row->recipe_part_id,
            (int)$row->ingredient_id,
            (string)$row->amount
        );
        $recipePartIngredient->setId((int)$row->id);

        return $recipePartIngredient;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $recipePartIngredients = [];

        foreach ($rows as $row) {
            $recipePartIngredient = new RecipePartIngredient(
                (int)$row->recipe_part_id,
                (int)$row->ingredient_id,
                (string)$row->amount
            );
            $recipePartIngredient->setId((int)$row->id);

            $recipePartIngredients[] = $recipePartIngredient;
        }

        return $recipePartIngredients;
    }

    public function findAllByRecipePartId(int $recipePartId): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM recipe_part_ingredient WHERE recipe_part_id = ?', $recipePartId)
            ->fetchAll();

        return $this->mapRowsToObjects($rows);
    }
}
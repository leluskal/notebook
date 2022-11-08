<?php
declare(strict_types=1);

namespace App\Model\Recipe;

use App\Model\BaseRepository;

class RecipeRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'recipe';
    }

    public function getById(int $id): ?Recipe
    {
        $row = $this->getDbConnection()->query('SELECT * FROM recipe WHERE id = ?', $id)->fetch();

        if ($row === null) {
            return null;
        }

        $recipe = new Recipe(
            (string)$row->name,
            (int)$row->new_recipe,
            (int)$row->recipe_category_id
        );
        $recipe->setId((int)$row->id);
        $recipe->setNote($row->note);
        $recipe->setRating($row->rating);
        $recipe->setImagePath($row->image_path);

        return $recipe;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $recipes = [];

        foreach ($rows as $row) {
            $recipe = new Recipe(
                (string)$row->name,
                (int)$row->new_recipe,
                (int)$row->recipe_category_id
            );
            $recipe->setId((int)$row->id);
            $recipe->setNote($row->note);
            $recipe->setRating($row->rating);
            $recipe->setImagePath($row->image_path);

            $recipes[] = $recipe;
        }

        return $recipes;
    }

    public function findAllByRecipeCategoryId(int $recipeCategoryId): array
    {
        $rows = $this->getDbConnection()
            ->query('SELECT * FROM recipe WHERE recipe_category_id = ?', $recipeCategoryId)->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    /**
     * @return Recipe[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM recipe')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $recipes = $this->findAll();

        $returnArray = [];

        foreach ($recipes as $recipe) {
            $returnArray[$recipe->getId()] = $recipe->getName();
        }

        return $returnArray;
    }
}
<?php
declare(strict_types=1);

namespace App\Model\RecipeCategory;

use App\Model\BaseRepository;

class RecipeCategoryRepository extends BaseRepository
{
    public function getTableName(): string
    {
        return 'recipe_category';
    }

    public function getById(int $id): ?RecipeCategory
    {
        $row = $this->getDbConnection()->query('SELECT * FROM recipe_category WHERE id = ?', $id)->fetch();

        if ($row === null) {
           return null;
        }

        $recipeCategory = new RecipeCategory(
            (string)$row->name
        );
        $recipeCategory->setId((int)$row->id);

        return $recipeCategory;
    }

    /**
     * @return RecipeCategory[]
     * @throws \Dibi\Exception
     */
    public function findAll(): array
    {
        $rows = $this->getDbConnection()->query('SELECT * FROM recipe_category')->fetchAll();

        return $this->mapRowsToObjects($rows);
    }

    public function findAllForSelectBox(): array
    {
        $recipeCategories = $this->findAll();

        $returnArray = [];

        foreach ($recipeCategories as $recipeCategory) {
            $returnArray[$recipeCategory->getId()] = $recipeCategory->getName();
        }

        return $returnArray;
    }

    public function mapRowsToObjects(array $rows): array
    {
        $recipeCategories = [];

        foreach ($rows as $row) {
            $recipeCategory = new RecipeCategory(
                (string)$row->name
            );
            $recipeCategory->setId((int)$row->id);

            $recipeCategories[] = $recipeCategory;

        }

        return $recipeCategories;
    }
}
<?php
declare(strict_types=1);

namespace App\Model\RecipePart;

use App\Model\Recipe\Recipe;

class RecipePart
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $recipeId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Recipe
     */
    private  $recipe;

    public function __construct(int $recipeId, string $name)
    {
        $this->recipeId = $recipeId;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRecipeId(): int
    {
        return $this->recipeId;
    }

    public function setRecipeId(int $recipeId): void
    {
        $this->recipeId = $recipeId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(Recipe $recipe): void
    {
        $this->recipe = $recipe;
    }
}
<?php
declare(strict_types=1);

namespace App\Model\RecipePartIngredient;

use App\Model\Ingredient\Ingredient;
use App\Model\RecipePart\RecipePart;

class RecipePartIngredient
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $recipePartId;

    /**
     * @var int
     */
    private $ingredientId;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var RecipePart
     */
    private $recipePart;

    /**
     * @var Ingredient
     */
    private $ingredient;

    public function __construct(int $recipePartId, int $ingredientId, string $amount)
    {
        $this->recipePartId = $recipePartId;
        $this->ingredientId = $ingredientId;
        $this->amount = $amount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRecipePartId(): int
    {
        return $this->recipePartId;
    }

    public function setRecipePartId(int $recipePartId): void
    {
        $this->recipePartId = $recipePartId;
    }

    public function getIngredientId(): int
    {
        return $this->ingredientId;
    }

    public function setIngredientId(int $ingredientId): void
    {
        $this->ingredientId = $ingredientId;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    public function getRecipePart(): RecipePart
    {
        return $this->recipePart;
    }

    public function setRecipePart(RecipePart $recipePart): void
    {
        $this->recipePart = $recipePart;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(Ingredient $ingredient): void
    {
        $this->ingredient = $ingredient;
    }
}
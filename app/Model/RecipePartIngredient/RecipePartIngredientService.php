<?php
declare(strict_types=1);

namespace App\Model\RecipePartIngredient;

use App\Model\Ingredient\IngredientRepository;
use App\Model\RecipePart\RecipePart;
use App\Model\RecipePart\RecipePartRepository;

class RecipePartIngredientService
{
    /**
     * @var RecipePartRepository
     */
    private $recipePartRepository;

    /**
     * @var IngredientRepository
     */
    private $ingredientRepository;

    /**
     * @var RecipePartIngredientRepository
     */
    private $recipePartIngredientRepository;

    public function __construct(
        RecipePartRepository $recipePartRepository,
        IngredientRepository $ingredientRepository,
        RecipePartIngredientRepository $recipePartIngredientRepository
    )
    {
        $this->recipePartRepository = $recipePartRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->recipePartIngredientRepository = $recipePartIngredientRepository;
    }

    public function mapEntities(RecipePartIngredient $recipePartIngredient): RecipePartIngredient
    {
        $recipePart = $this->recipePartRepository->getById($recipePartIngredient->getRecipePartId());
        $ingredient = $this->ingredientRepository->getById($recipePartIngredient->getIngredientId());

        $recipePartIngredient->setRecipePart($recipePart);
        $recipePartIngredient->setIngredient($ingredient);

        return $recipePartIngredient;
    }

    public function mapEntitiesToArray(array $recipePartIngredients): array
    {
        $mappedEntities = [];

        foreach ($recipePartIngredients as $recipePartIngredient) {
            $mappedEntities[] = $this->mapEntities($recipePartIngredient);
        }

        return $mappedEntities;
    }

    /**
     * @param RecipePart[] $recipeParts
     * @return array
     */
    public function findAllGroupedByRecipeParts(array $recipeParts): array
    {
        $ingredientsGroupedByRecipePart = [];
        /** @var RecipePart $recipePart */
        foreach ($recipeParts as $recipePart) {
            $recipePartIngredients = $this->recipePartIngredientRepository->findAllByRecipePartId($recipePart->getId());
            $recipePartIngredients = $this->mapEntitiesToArray($recipePartIngredients);

            foreach ($recipePartIngredients as $recipePartIngredient) {
                $key = $recipePart->getName() . '-' . $recipePart->getId();
                $ingredientsGroupedByRecipePart[$key][] = $recipePartIngredient;
            }
        }

        return $ingredientsGroupedByRecipePart;
    }
}
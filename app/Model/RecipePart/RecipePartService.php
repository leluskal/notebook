<?php
declare(strict_types=1);

namespace App\Model\RecipePart;

use App\Model\Recipe\RecipeRepository;

class RecipePartService
{
    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    /**
     * @var RecipePartRepository
     */
    private $recipePartRepository;

    public function __construct(RecipeRepository $recipeRepository, RecipePartRepository $recipePartRepository)
    {
        $this->recipeRepository = $recipeRepository;
        $this->recipePartRepository = $recipePartRepository;
    }

    public function mapEntity(RecipePart $recipePart): RecipePart
    {
        $recipe = $this->recipeRepository->getById($recipePart->getRecipeId());

        $recipePart->setRecipe($recipe);

        return $recipePart;
    }

    public function mapEntityToArray(array $recipeParts): array
    {
        $mappedEntities = [];

        foreach ($recipeParts as $recipePart) {
            $mappedEntities[] = $this->mapEntity($recipePart);
        }

        return $mappedEntities;
    }

    public function findAllForSelectBox(int $recipeId): array
    {
        $recipeParts = $this->recipePartRepository->findAllByRecipeId($recipeId);
        $recipeParts = $this->mapEntityToArray($recipeParts);

        $returnArray = [];

        foreach ($recipeParts as $recipePart) {
            $recipe = $recipePart->getRecipe()->getName();
            $returnArray[$recipePart->getId()] = $recipe . ' - ' . $recipePart->getName();
        }

        return $returnArray;
    }
}
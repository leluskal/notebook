<?php
declare(strict_types=1);

namespace App\Model\RecipePartMethod;

use App\Model\RecipePart\RecipePart;
use App\Model\RecipePart\RecipePartRepository;

class RecipePartMethodService
{
    /**
     * @var RecipePartRepository
     */
    private $recipePartRepository;

    /**
     * @var RecipePartMethodRepository
     */
    private $recipePartMethodRepository;

    public function __construct(
        RecipePartRepository $recipePartRepository,
        RecipePartMethodRepository $recipePartMethodRepository
    )
    {
        $this->recipePartRepository = $recipePartRepository;
        $this->recipePartMethodRepository = $recipePartMethodRepository;
    }

    public function mapEntity(RecipePartMethod $recipePartMethod): RecipePartMethod
    {
        $recipePart = $this->recipePartRepository->getById($recipePartMethod->getRecipePartId());

        $recipePartMethod->setRecipePart($recipePart);

        return $recipePartMethod;
    }

    public function mapEntityToArray(array $recipePartMethods): array
    {
        $mappedEntities = [];

        foreach ($recipePartMethods as $recipePartMethod) {
            $mappedEntities[] = $this->mapEntity($recipePartMethod);
        }

        return $mappedEntities;
    }

    /**
     * @param RecipePart[] $recipeParts
     * @return array
     */
    public function findAllGroupedByRecipeParts(array $recipeParts): array
    {
        $methodsGroupedByRecipePart = [];

        foreach ($recipeParts as $recipePart) {
            $recipePartMethods = $this->recipePartMethodRepository->findAllByRecipePartId($recipePart->getId());
            $recipePartMethods = $this->mapEntityToArray($recipePartMethods);

            foreach ($recipePartMethods as $recipePartMethod) {
                $methodsGroupedByRecipePart[$recipePart->getName()][] = $recipePartMethod;
            }
        }

        return $methodsGroupedByRecipePart;
    }
}
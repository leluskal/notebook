<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\RecipePartIngredient;

use App\Model\Ingredient\IngredientRepository;
use App\Model\RecipePart\RecipePartRepository;
use App\Model\RecipePart\RecipePartService;
use App\Model\RecipePartIngredient\RecipePartIngredientRepository;

class RecipePartIngredientFormFactory
{
    /**
     * @var RecipePartService
     */
    private $recipePartService;

    /**
     * @var IngredientRepository
     */
    private $ingredientRepository;

    /**
     * @var RecipePartIngredientRepository
     */
    private $recipePartIngredientRepository;

    public function __construct(
        RecipePartService $recipePartService,
        IngredientRepository $ingredientRepository,
        RecipePartIngredientRepository $recipePartIngredientRepository
    )
    {
        $this->recipePartService = $recipePartService;
        $this->ingredientRepository = $ingredientRepository;
        $this->recipePartIngredientRepository = $recipePartIngredientRepository;
    }

    public function create(int $recipeId): RecipePartIngredientForm
    {
        $recipeForm =  new RecipePartIngredientForm(
            $this->recipePartService,
            $this->ingredientRepository,
            $this->recipePartIngredientRepository
        );

        $recipeForm->setRecipeId($recipeId);

        return $recipeForm;
    }
}
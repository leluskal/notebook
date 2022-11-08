<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Recipe;

use App\Model\Recipe\RecipeRepository;
use App\Model\RecipeCategory\RecipeCategoryRepository;

class RecipeFormFactory
{
    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    /**
     * @var RecipeCategoryRepository
     */
    private $recipeCategoryRepository;

    public function __construct(
        RecipeRepository $recipeRepository,
        RecipeCategoryRepository $recipeCategoryRepository
    )
    {
        $this->recipeRepository = $recipeRepository;
        $this->recipeCategoryRepository = $recipeCategoryRepository;
    }

    public function create(): RecipeForm
    {
        return new RecipeForm($this->recipeRepository, $this->recipeCategoryRepository);
    }
}
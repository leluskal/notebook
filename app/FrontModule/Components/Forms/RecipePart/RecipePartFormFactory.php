<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\RecipePart;

use App\Model\Recipe\RecipeRepository;
use App\Model\RecipePart\RecipePartRepository;

class RecipePartFormFactory
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

    public function create(): RecipePartForm
    {
        return new RecipePartForm($this->recipeRepository, $this->recipePartRepository);
    }
}
<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\RecipePartMethod;

use App\Model\RecipePart\RecipePartRepository;
use App\Model\RecipePart\RecipePartService;
use App\Model\RecipePartMethod\RecipePartMethodRepository;

class RecipePartMethodFormFactory
{
    /**
     * @var RecipePartService
     */
    private $recipePartService;

    /**
     * @var RecipePartMethodRepository
     */
    private $recipePartMethodRepository;

    public function __construct(
        RecipePartService $recipePartService,
        RecipePartMethodRepository $recipePartMethodRepository
    )
    {
        $this->recipePartService = $recipePartService;
        $this->recipePartMethodRepository = $recipePartMethodRepository;
    }

    public function create(int $recipeId): RecipePartMethodForm
    {
        $recipeForm = new RecipePartMethodForm($this->recipePartService, $this->recipePartMethodRepository);

        $recipeForm->setRecipeId($recipeId);

        return $recipeForm;
    }
}
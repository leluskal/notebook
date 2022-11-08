<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\RecipePartIngredient\RecipePartIngredientForm;
use App\FrontModule\Components\Forms\RecipePartIngredient\RecipePartIngredientFormFactory;
use App\Model\RecipePart\RecipePartRepository;
use App\Model\RecipePartIngredient\RecipePartIngredientRepository;

class RecipePartIngredientPresenter extends BasePresenter
{
    /**
     * @var RecipePartIngredientRepository
     */
    private $recipePartIngredientRepository;

    /**
     * @var RecipePartIngredientFormFactory
     */
    private $recipePartIngredientFormFactory;

    /**
     * @var int
     */
    private $recipeId;

    public function __construct(
        RecipePartIngredientRepository $recipePartIngredientRepository,
        RecipePartIngredientFormFactory $recipePartIngredientFormFactory
    )
    {
        $this->recipePartIngredientRepository = $recipePartIngredientRepository;
        $this->recipePartIngredientFormFactory = $recipePartIngredientFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutEating');
    }

    public function createComponentRecipePartIngredientForm(): RecipePartIngredientForm
    {
        return $this->recipePartIngredientFormFactory->create((int) $this->recipeId);
    }

    public function actionCreate(int $recipeId)
    {
        $this->recipeId = $recipeId;
    }

    public function actionEdit(int $recipeId)
    {
        $this->recipeId = $recipeId;
    }

    public function renderEdit(int $id)
    {
        $ingredient = $this->recipePartIngredientRepository->getById($id);
        $this->template->ingredient = $ingredient;

        $this['recipePartIngredientForm']['form']['id']->setDefaultValue($ingredient->getId());
        $this['recipePartIngredientForm']['form']['recipe_part_id']->setDefaultValue($ingredient->getRecipePartId());
        $this['recipePartIngredientForm']['form']['ingredient_id']->setDefaultValue($ingredient->getIngredientId());
        $this['recipePartIngredientForm']['form']['amount']->setDefaultValue($ingredient->getAmount());
    }

    public function renderCreate(int $recipeId)
    {

    }
}
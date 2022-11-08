<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Recipe\RecipeForm;
use App\FrontModule\Components\Forms\Recipe\RecipeFormFactory;
use App\Model\Recipe\RecipeRepository;
use App\Model\RecipeCategory\RecipeCategoryRepository;
use App\Model\RecipePart\RecipePartRepository;
use App\Model\RecipePartIngredient\RecipePartIngredientRepository;
use App\Model\RecipePartIngredient\RecipePartIngredientService;
use App\Model\RecipePartMethod\RecipePartMethodService;

class RecipePresenter extends BasePresenter
{
    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    /**
     * @var RecipeFormFactory
     */
    private $recipeFormFactory;

    /**
     * @var RecipeCategoryRepository
     */
    private $recipeCategoryRepository;

    /**
     * @var RecipePartRepository
     */
    private $recipePartRepository;

    /**
     * @var RecipePartIngredientRepository
     */
    private $recipePartIngredientRepository;

    /**
     * @var RecipePartIngredientService
     */
    private $recipePartIngredientService;

    /**
     * @var RecipePartMethodService
     */
    private $recipePartMethodService;

    public function __construct(
        RecipeRepository $recipeRepository,
        RecipeFormFactory $recipeFormFactory,
        RecipeCategoryRepository $recipeCategoryRepository,
        RecipePartRepository $recipePartRepository,
        RecipePartIngredientRepository $recipePartIngredientRepository,
        RecipePartIngredientService $recipePartIngredientService,
        RecipePartMethodService $recipePartMethodService
    )
    {
        $this->recipeRepository = $recipeRepository;
        $this->recipeFormFactory = $recipeFormFactory;
        $this->recipeCategoryRepository = $recipeCategoryRepository;
        $this->recipePartRepository = $recipePartRepository;
        $this->recipePartIngredientRepository = $recipePartIngredientRepository;
        $this->recipePartIngredientService = $recipePartIngredientService;
        $this->recipePartMethodService = $recipePartMethodService;

    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutEating');
    }

    public function renderDefault(int $recipeCategoryId = null)
    {
        $recipes = $this->recipeRepository->findAllByRecipeCategoryId((int) $recipeCategoryId);

        if ($recipeCategoryId !== null) {
            $this->template->recipes = $recipes;
        }

        $this->template->recipeCategories = $this->recipeCategoryRepository->findAll();
        $this->template->recipeCategoryId = $recipeCategoryId;
    }

    public function createComponentRecipeForm(): RecipeForm
    {
        return $this->recipeFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $recipe = $this->recipeRepository->getById($id);
        $this->template->recipe = $recipe;

        $this['recipeForm']['form']['id']->setDefaultValue($recipe->getId());
        $this['recipeForm']['form']['name']->setDefaultValue($recipe->getName());
        $this['recipeForm']['form']['new_recipe']->setDefaultValue($recipe->getNewRecipe());
        $this['recipeForm']['form']['recipe_category_id']->setDefaultValue($recipe->getRecipeCategoryId());
        $this['recipeForm']['form']['note']->setDefaultValue($recipe->getNote());
        $this['recipeForm']['form']['rating']->setDefaultValue($recipe->getRating());
        $this['recipeForm']['form']['image']->setDefaultValue($recipe->getImagePath());
    }

    public function renderCreate(int $recipeCategoryId)
    {
        $this['recipeForm']['form']['recipe_category_id']->setDefaultValue($recipeCategoryId);
    }

    public function renderDetail(int $recipeId)
    {
        $recipe = $this->recipeRepository->getById($recipeId);
        $this->template->recipe = $recipe;

        $this->template->recipeParts = $this->recipePartRepository->findAllByRecipeId($recipeId);

        $recipeParts = $this->recipePartRepository->findAllByRecipeId($recipeId);

        $this->template->recipePartIngredients = $this->recipePartIngredientService->findAllGroupedByRecipeParts($recipeParts);
        $this->template->recipePartMethods = $this->recipePartMethodService->findAllGroupedByRecipeParts($recipeParts);
    }
}
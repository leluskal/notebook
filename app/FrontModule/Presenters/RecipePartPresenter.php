<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\RecipePart\RecipePartForm;
use App\FrontModule\Components\Forms\RecipePart\RecipePartFormFactory;
use App\Model\RecipePart\RecipePartRepository;

class RecipePartPresenter extends BasePresenter
{
    /**
     * @var RecipePartRepository
     */
    private $recipePartRepository;

    /**
     * @var RecipePartFormFactory
     */
    private $recipePartFormFactory;

    public function __construct(RecipePartRepository $recipePartRepository, RecipePartFormFactory $recipePartFormFactory)
    {
        $this->recipePartRepository = $recipePartRepository;
        $this->recipePartFormFactory = $recipePartFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutEating');
    }

    public function createComponentRecipePartForm(): RecipePartForm
    {
        return $this->recipePartFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $recipePart = $this->recipePartRepository->getById($id);
        $this->template->recipePart = $recipePart;

        $this['recipePartForm']['form']['id']->setDefaultValue($recipePart->getId());
        $this['recipePartForm']['form']['recipe_id']->setDefaultValue($recipePart->getRecipeId());
        $this['recipePartForm']['form']['name']->setDefaultValue($recipePart->getName());
    }

    public function renderCreate(int $recipeId)
    {
        $this['recipePartForm']['form']['recipe_id']->setDefaultValue($recipeId);
    }
}
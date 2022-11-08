<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\RecipeCategory\RecipeCategoryForm;
use App\AdminModule\Components\Forms\RecipeCategory\RecipeCategoryFormFactory;
use App\Model\RecipeCategory\RecipeCategoryRepository;
use App\Presenters\BaseAuthorizedPresenter;

class RecipeCategoryPresenter extends BaseAuthorizedPresenter
{
    /**
     * @var RecipeCategoryRepository
     */
    private $recipeCategoryRepository;

    /**
     * @var RecipeCategoryFormFactory
     */
    private $recipeCategoryFormFactory;

    public function __construct(
        RecipeCategoryRepository $recipeCategoryRepository,
        RecipeCategoryFormFactory $recipeCategoryFormFactory
    )
    {
        $this->recipeCategoryRepository = $recipeCategoryRepository;
        $this->recipeCategoryFormFactory = $recipeCategoryFormFactory;
    }

    public function renderDefault()
    {
        $this->template->recipeCategories = $this->recipeCategoryRepository->findAll();
    }

    public function createComponentRecipeCategoryForm(): RecipeCategoryForm
    {
        return $this->recipeCategoryFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $recipeCategory = $this->recipeCategoryRepository->getById($id);
        $this->template->recipeCategory = $recipeCategory;

        $this['recipeCategoryForm']['form']['id']->setDefaultValue($recipeCategory->getId());
        $this['recipeCategoryForm']['form']['name']->setDefaultValue($recipeCategory->getName());
    }

    public function renderCreate()
    {

    }

    public function handleDeleteRecipeCategory(int $id)
    {
        $this->recipeCategoryRepository->deleteById($id);

        $this->flashMessage('The recipe category is deleted', 'info');
        $this->redirect('RecipeCategory:default');
    }
}
<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\RecipePartMethod\RecipePartMethodForm;
use App\FrontModule\Components\Forms\RecipePartMethod\RecipePartMethodFormFactory;
use App\Model\RecipePartMethod\RecipePartMethodRepository;

class RecipePartMethodPresenter extends BasePresenter
{
    /**
     * @var RecipePartMethodRepository
     */
    private $recipePartMethodRepository;

    /**
     * @var RecipePartMethodFormFactory
     */
    private $recipePartMethodFormFactory;

    /**
     * @var int
     */
    private $recipeId;

    public function __construct(
        RecipePartMethodRepository $recipePartMethodRepository,
        RecipePartMethodFormFactory $recipePartMethodFormFactory
    )
    {
        $this->recipePartMethodRepository = $recipePartMethodRepository;
        $this->recipePartMethodFormFactory = $recipePartMethodFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutEating');
    }

    public function createComponentRecipePartMethodForm(): RecipePartMethodForm
    {
        return $this->recipePartMethodFormFactory->create((int) $this->recipeId);
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
        $method = $this->recipePartMethodRepository->getById($id);
        $this->template->method = $method;

        $this['recipePartMethodForm']['form']['id']->setDefaultValue($method->getId());
        $this['recipePartMethodForm']['form']['recipe_part_id']->setDefaultValue($method->getRecipePartId());
        $this['recipePartMethodForm']['form']['sort']->setDefaultValue($method->getSort());
        $this['recipePartMethodForm']['form']['method']->setDefaultValue($method->getMethod());
    }

    public function create(int $recipeId)
    {

    }
}
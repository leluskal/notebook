<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\Forms\Ingredient\IngredientForm;
use App\FrontModule\Components\Forms\Ingredient\IngredientFormFactory;
use App\Model\Ingredient\Ingredient;
use App\Model\Ingredient\IngredientRepository;

class IngredientPresenter extends BasePresenter
{
    /**
     * @var IngredientRepository
     */
    private $ingredientRepository;

    /**
     * @var IngredientFormFactory
     */
    private $ingredientFormFactory;

    public function __construct(IngredientRepository $ingredientRepository, IngredientFormFactory $ingredientFormFactory)
    {
        $this->ingredientRepository = $ingredientRepository;
        $this->ingredientFormFactory = $ingredientFormFactory;
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout('layoutEating');
    }

    public function renderDefault()
    {
        $this->template->sortedIngredients = $this->ingredientRepository->findAllByFirstCharacter();
    }

    public function createComponentIngredientForm(): IngredientForm
    {
        return $this->ingredientFormFactory->create();
    }

    public function renderEdit(int $id)
    {
        $ingredient = $this->ingredientRepository->getById($id);
        $this->template->ingredient = $ingredient;

        $this['ingredientForm']['form']['id']->setDefaultValue($ingredient->getId());
        $this['ingredientForm']['form']['name']->setDefaultValue($ingredient->getName());
    }

    public function renderCreate()
    {

    }
}
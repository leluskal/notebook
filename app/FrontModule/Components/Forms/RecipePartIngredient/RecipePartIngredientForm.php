<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\RecipePartIngredient;

use App\Model\Ingredient\IngredientRepository;
use App\Model\RecipePart\RecipePartRepository;
use App\Model\RecipePart\RecipePartService;
use App\Model\RecipePartIngredient\RecipePartIngredientRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class RecipePartIngredientForm extends Control
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

    /**
     * @var int
     */
    private $recipeId;

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

    /**
     * @param int $recipeId
     */
    public function setRecipeId(int $recipeId): void
    {
        $this->recipeId = $recipeId;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('recipe_part_id', 'Recipe Part', $this->recipePartService->findAllForSelectBox($this->recipeId))
             ->setPrompt('--Choose recipe part--')
             ->setRequired('The recipe part is required');

        $form->addSelect('ingredient_id', 'Ingredient', $this->ingredientRepository->findAllForSelectBox())
             ->setPrompt('--Choose ingredient--')
             ->setRequired('The ingredient is required');

        $form->addText('amount', 'Amount Of Ingredient')
             ->setRequired('The amount is required');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->recipePartIngredientRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record is deleted', 'info');
            $this->getPresenter()->redirect('Recipe:detail', ['recipeId' => $this->recipeId]);
        }

        if ($values->id === '') {
            $this->recipePartIngredientRepository->create([
                'recipe_part_id' => $values->recipe_part_id,
                'ingredient_id' => $values->ingredient_id,
                'amount' => $values->amount
            ]);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'recipe_part_id' => $values->recipe_part_id,
                'ingredient_id' => $values->ingredient_id,
                'amount' => $values->amount
            ];

            $this->recipePartIngredientRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->getPresenter()->redirect('Recipe:detail', ['recipeId' => $this->recipeId]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ . '/recipePartIngredientForm.latte');
        $template->render();
    }
}
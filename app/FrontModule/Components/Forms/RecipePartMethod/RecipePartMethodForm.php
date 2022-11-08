<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\RecipePartMethod;

use App\Model\RecipePart\RecipePartRepository;
use App\Model\RecipePart\RecipePartService;
use App\Model\RecipePartMethod\RecipePartMethodRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class RecipePartMethodForm extends Control
{
    /**
     * @var RecipePartService
     */
    private $recipePartService;

    /**
     * @var RecipePartMethodRepository
     */
    private $recipePartMethodRepository;

    /**
     * @var int
     */
    private $recipeId;

    public function __construct(
        RecipePartService $recipePartService,
        RecipePartMethodRepository $recipePartMethodRepository
    )
    {
        $this->recipePartService = $recipePartService;
        $this->recipePartMethodRepository = $recipePartMethodRepository;
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

        $form->addInteger('sort', 'Sort')
             ->setRequired('The sort is required');

        $form->addTextArea('method', 'Method')
             ->setRequired('The method is required');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->recipePartMethodRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record is deleted', 'info');
            $this->getPresenter()->redirect('Recipe:detail', ['recipeId' => $this->recipeId]);
        }

        if ($values->id === '') {
            $this->recipePartMethodRepository->create([
                'recipe_part_id' => $values->recipe_part_id,
                'sort' => $values->sort,
                'method' => $values->method
            ]);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'recipe_part_id' => $values->recipe_part_id,
                'sort' => $values->sort,
                'method' => $values->method
            ];

            $this->recipePartMethodRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->getPresenter()->redirect('Recipe:detail', ['recipeId' => $this->recipeId]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/recipePartMethodForm.latte');
        $template->render();
    }
}
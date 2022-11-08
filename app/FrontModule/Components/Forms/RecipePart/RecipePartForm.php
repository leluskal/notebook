<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\RecipePart;

use App\Model\Recipe\RecipeRepository;
use App\Model\RecipePart\RecipePartRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class RecipePartForm extends Control
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

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('recipe_id', 'Recipe', $this->recipeRepository->findAllForSelectBox())
             ->setPrompt('--Choose recipe--');

        $form->addText('name', 'Recipe Part')
             ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->recipePartRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The recipe part is deleted', 'info');
            $this->getPresenter()->redirect('Recipe:detail', ['recipeId' => $values->recipe_id]);
        }

        if ($values->id === '') {
            $this->recipePartRepository->create([
                'recipe_id' => $values->recipe_id,
                'name' => $values->name
            ]);
            $this->getPresenter()->flashMessage('The new recipe part is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'recipe_id' => $values->recipe_id,
                'name' => $values->name
            ];

            $this->recipePartRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The recipe part is updated', 'info');
        }

        $this->getPresenter()->redirect('Recipe:detail', ['recipeId' => $values->recipe_id]);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/recipePartForm.latte');
        $template->render();
    }
}
<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Ingredient;

use App\Model\Ingredient\IngredientRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class IngredientForm extends Control
{
    /**
     * @var IngredientRepository
     */
    private $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Ingredient');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->ingredientRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The ingredient is deleted', 'info');
            $this->getPresenter()->redirect('Ingredient:default');
        }

        if ($values->id === '') {
            $this->ingredientRepository->create([
                'name' => $values->name
            ]);
            $this->getPresenter()->flashMessage('The new ingredient is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name
            ];

            $this->ingredientRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The ingredient is updated', 'info');
        }

        $this->getPresenter()->redirect('Ingredient:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/ingredientForm.latte');
        $template->render();
    }
}
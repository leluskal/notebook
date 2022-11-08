<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RecipeCategory;

use App\Model\RecipeCategory\RecipeCategoryRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class RecipeCategoryForm extends Control
{
    /**
     * @var RecipeCategoryRepository
     */
    private $recipeCategoryRepository;

    public function __construct(RecipeCategoryRepository $recipeCategoryRepository)
    {
        $this->recipeCategoryRepository = $recipeCategoryRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Category')
             ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $this->recipeCategoryRepository->create([
                'name' => $values->name
            ]);
            $this->getPresenter()->flashMessage('The new recipe category is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name
            ];

            $this->recipeCategoryRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The recipe category is updated', 'info');
        }

        $this->getPresenter()->redirect('RecipeCategory:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/recipeCategoryForm.latte');
        $template->render();
    }
}
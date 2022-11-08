<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\FurnishingCategory;

use App\Model\FurnishingCategory\FurnishingCategoryRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class FurnishingCategoryForm extends Control
{
    /**
     * @var FurnishingCategoryRepository
     */
    private $furnishingCategoryRepository;

    public function __construct(FurnishingCategoryRepository $furnishingCategoryRepository)
    {
        $this->furnishingCategoryRepository = $furnishingCategoryRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Furnishing Category')
             ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $this->furnishingCategoryRepository->create([
                'name' => $values->name
            ]);
            $this->getPresenter()->flashMessage('The new category is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'name' => $values->name
            ];

            $this->furnishingCategoryRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The category is updated', 'info');
        }

        $this->getPresenter()->redirect('FurnishingCategory:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/furnishingCategoryForm.latte');
        $template->render();
    }
}
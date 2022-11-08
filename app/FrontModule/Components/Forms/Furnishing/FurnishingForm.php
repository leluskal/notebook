<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\Furnishing;

use App\Model\Furnishing\FurnishingRepository;
use App\Model\FurnishingCategory\FurnishingCategoryRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class FurnishingForm extends Control
{
    /**
     * @var FurnishingCategoryRepository
     */
    private $furnishingCategoryRepository;

    /**
     * @var FurnishingRepository
     */
    private $furnishingRepository;

    public function __construct(
        FurnishingCategoryRepository $furnishingCategoryRepository,
        FurnishingRepository $furnishingRepository
    )
    {
        $this->furnishingCategoryRepository = $furnishingCategoryRepository;
        $this->furnishingRepository = $furnishingRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('furnishing_category_id', 'Category', $this->furnishingCategoryRepository->findAllForSelectBox());

        $form->addText('name', 'Furnishing')
             ->setRequired('The name is required');

        $form->addTextArea('note', 'Note');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $this->furnishingRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The furnishing is deleted', 'info');
            $this->getPresenter()->redirect('Furnishing:default');
        }

        if ($values->id === '') {
            $this->furnishingRepository->create([
                'furnishing_category_id' => $values->furnishing_category_id,
                'name' => $values->name,
                'note' => $values->note !== '' ? $values->note : null
            ]);
            $this->getPresenter()->flashMessage('The new furnishing is saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'furnishing_category_id' => $values->furnishing_category_id,
                'name' => $values->name,
                'note' => $values->note !== '' ? $values->note : null
            ];

            $this->furnishingRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The furnishing is updated', 'info');
        }

        $this->getPresenter()->redirect('Furnishing:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/furnishingForm.latte');
        $template->render();
    }
}
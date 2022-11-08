<?php
declare(strict_types=1);

namespace App\FrontModule\Components\Forms\FurnishingExpense;

use App\Model\FurnishingExpense\FurnishingExpenseRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class FurnishingExpenseForm extends Control
{
    /**
     * @var FurnishingExpenseRepository
     */
    private $furnishingExpenseRepository;

    public function __construct(FurnishingExpenseRepository $furnishingExpenseRepository)
    {
        $this->furnishingExpenseRepository = $furnishingExpenseRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('furnishings', 'Furnishings')
             ->setRequired('The furnishings are required');

        $form->addInteger('price', 'Price')
             ->setRequired('The price is required');

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
            $this->furnishingExpenseRepository->deleteById((int) $values->id);
            $this->getPresenter()->flashMessage('The record is deleted', 'info');
            $this->getPresenter()->redirect('FurnishingExpense:default');
        }

            if ($values->id === '') {
            $this->furnishingExpenseRepository->create([
                'furnishings' => $values->furnishings,
                'price' => $values->price,
                'note' => $values->note !== '' ? $values->note : null
            ]);
            $this->getPresenter()->flashMessage('The new record i saved', 'success');
        } else {
            $id = (int) $values->id;
            $data = [
                'furnishings' => $values->furnishings,
                'price' => $values->price,
                'note' => $values->note !== '' ? $values->note : null
            ];

            $this->furnishingExpenseRepository->updateById($id, $data);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->getPresenter()->redirect('FurnishingExpense:default');
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/furnishingExpenseForm.latte');
        $template->render();
    }
}